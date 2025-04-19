<?php

namespace Aaran\BMS\Billing\Reports\Controllers\Contact;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Aaran\BMS\Billing\Master\Models\Company;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Aaran\BMS\Billing\Transaction\Models\Transaction;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;


class  PartyReportController extends Controller
{
    use  TenantAwareTrait;
    public function __invoke($id, $month = null, $year = null)
    {
        // Default to current month/year
        $month = $month ?? now()->month;
        $year = $year ?? now()->year;

        // Create date range
        $start_date = now()->setMonth($month)->setYear($year)->startOfMonth()->format('Y-m-d');
        $end_date = now()->setMonth($month)->setYear($year)->endOfMonth()->format('Y-m-d');

        $contact = $this->getList($id, $start_date, $end_date);
        $this->getBalance($id, $start_date, $end_date);

        Pdf::setOption([
            'dpi' => 150,
            'defaultPaperSize' => 'a4',
            'defaultFont' => 'sans-serif',
        ]);

        $pdf = Pdf::loadView('Ui::components.pdf-view.report.Contact.party_report', [
            'list' => $contact,
            'cmp' => Company::on($this->getTenantConnection())->printDetails(session()->get('company_id')),
            'contact' => Contact::on($this->getTenantConnection())->find($id),
            'start_date' => date('d-m-Y', strtotime($start_date)),
            'end_date' => date('d-m-Y', strtotime($end_date)),
            'billing_address' => ContactAddress::on($this->getTenantConnection())->printDetails($this->contact_detail_id),
            'opening_balance' => $this->opening_balance,
            'party' => $id
        ]);

        return $pdf->stream();
    }

    #region[opening_balance]

    public mixed $opening_balance;
    public mixed $sale_total = 0;
    public mixed $receipt_total = 0;
    public mixed $contact_detail_id ;
    public function getBalance($byParty, $start_date, $end_date)
    {
        $obj = Contact::on($this->getTenantConnection())->find($byParty);
        $this->opening_balance = $obj->opening_balance;

//        $this->sale_total = Sale::on($this->getTenantConnection())->whereDate('invoice_date', '<', $start_date)
//            ->where('contact_id','=',$byParty)
//            ->sum('grand_total');

        $this->receipt_total = Transaction::on($this->getTenantConnection())->whereDate('vdate', '<', $start_date)
            ->where('contact_id','=',$byParty)
            ->where('mode_id','=',111)
            ->sum('vname');

        $this->opening_balance = $this->opening_balance + $this->sale_total - $this->receipt_total;

        $this->contact_detail_id=ContactAddress::on($this->getTenantConnection())->where('contact_id', '=', $byParty)->first()->id;

    }
    #endregion

    private function getList($byParty, $start_date, $end_date)
    {
        $receipt = Transaction::on($this->getTenantConnection())->select([
            'transactions.company_id',
            'transactions.contact_id',
            DB::raw("'receipt' as mode"),
            "transactions.id as vno",
            'transactions.vdate as vdate',
            DB::raw("'' as grand_total"),
            'transactions.vname',
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $byParty)
            ->where('mode_id', '=', 111)
            ->whereBetween('vdate', [$start_date, $end_date])
//            ->whereDate('vdate', '>=', $start_date ?: $invoiceDate_first)
//            ->whereDate('vdate', '<=', $end_date ?: Carbon::now()->format('Y-m-d'))
            ->where('company_id', '=', session()->get('company_id'));

        $payment = Transaction::on($this->getTenantConnection())->select([
            'transactions.company_id',
            'transactions.contact_id',
            DB::raw("'payment' as mode"),
            "transactions.id as vno",
            'transactions.vdate as vdate',
            DB::raw("'' as grand_total"),
            'transactions.vname',
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $byParty)
            ->where('mode_id','=',110)
            ->whereBetween('vdate', [$start_date, $end_date])
//            ->whereDate('vdate', '>=', $start_date ?: $invoiceDate_first)
//            ->whereDate('vdate', '<=', $end_date ?: carbon::now()->format('Y-m-d'))
            ->where('company_id', '=', session()->get('company_id'));


        $purchase = Purchase::on($this->getTenantConnection())->select([
            'purchases.company_id',
            'purchases.contact_id',
            DB::raw("'Purchase Invoice' as mode"),
            "purchases.purchase_no as vno",
            'purchases.purchase_date as vdate',
            'purchases.grand_total',
            DB::raw("'' as transaction_amount"),
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $byParty)
            ->whereBetween('purchase_date', [$start_date, $end_date])
//            ->whereDate('purchase_date', '>=', $start_date ?: $invoiceDate_first)
//            ->whereDate('purchase_date', '<=', $end_date ?: Carbon::now()->format('Y-m-d'))
            ->where('company_id', '=', session()->get('company_id'));


        $salesInvoice = Sale::on($this->getTenantConnection())->select([
            "sales.company_id",
            "sales.contact_id",
            DB::raw("'Sales Invoice' as mode"),
            "sales.invoice_no as vno",
            "sales.invoice_date as vdate",
            "sales.grand_total",
            DB::raw("'' as transaction_amount"),
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $byParty)
            ->whereBetween('invoice_date', [$start_date, $end_date])
//            ->whereDate('invoice_date', '>=', $start_date )
//            ->whereDate('invoice_date', '<=', $end_date )
            ->where('company_id', '=', session()->get('company_id'));


        $combined = $salesInvoice->toBase()
            ->union($purchase->toBase())
            ->union($payment->toBase())
            ->union($receipt->toBase());

        return DB::table(DB::raw("({$combined->toSql()}) as combined"))
            ->mergeBindings($combined)
            ->orderBy('vdate')
            ->orderBy('mode')
            ->get();
    }



}
