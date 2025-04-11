<?php

namespace Aaran\BMS\Billing\Reports\Controllers;

use Aaran\Entries\Models\Purchase;
use Aaran\BMS\Billing\Master\Models\Company;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactDetail;
use Aaran\Transaction\Models\Transaction;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PayablesController extends Controller
{
    public function __invoke($party, $start_date, $end_date)
    {
        $purchase = $this->getList($party, $start_date, $end_date);
        $this->getBalance($party, $start_date, $end_date);
//        return pdf('pdf-view.report.payables', [
        Pdf::setOption(['dpi' => 150, 'defaultPaperSize' => 'a4', 'defaultFont' => 'sans-serif','fontDir']);

        $pdf = PDF::loadView('aaran-ui::components.pdf-view.report.payables',
            [
            'list' => $purchase,
            'cmp' => Company::printDetails(session()->get('company_id')),
            'contact' => Contact::find($party),
            'start_date' => date('d-m-Y', strtotime($start_date)),
            'end_date' => date('d-m-Y', strtotime($end_date)),
            'billing_address' => ContactDetail::printDetails($this->contact_detail_id),
            'opening_balance'=>$this->opening_balance ,
            'party'=>$party
        ]);
        $pdf->render();

        return $pdf->stream();
    }
    #region[opening_balance]

    public mixed $opening_balance;
    public mixed $sale_total = 0;
    public mixed $receipt_total = 0;
    public mixed $contact_detail_id ;
    public function getBalance($party, $start_date, $end_date)
    {
        $obj = Contact::find($party);
        $this->opening_balance = $obj->opening_balance;

        $this->sale_total = Purchase::whereDate('purchase_date', '<', $start_date)
            ->where('contact_id','=',$party)
            ->sum('grand_total');

        $this->receipt_total = Transaction::whereDate('vdate', '<', $start_date)
            ->where('contact_id','=',$party)
            ->where('mode_id','=',110)
            ->sum('vname');

        $this->opening_balance = $this->opening_balance + $this->sale_total - $this->receipt_total;

        $this->contact_detail_id=ContactDetail::where('contact_id', '=', $party)->first()->id;
    }
    #endregion

    private function getList($party, $start_date, $end_date)
    {
        $purchase = Transaction::select([
            'transactions.company_id',
            'transactions.contact_id',
            DB::raw("'payment' as mode"),
            "transactions.id as vno",
            'transactions.vdate as vdate',
            DB::raw("'' as grand_total"),
            'transactions.vname',
            'transactions.chq_no',
        ])
            ->where('contact_id', '=', $party)
            ->whereBetween('vdate', [$start_date, $end_date])
            ->where('mode_id','=',110)
            ->where('company_id', '=', session()->get('company_id'));
        return Purchase::select([
            'purchases.company_id',
            'purchases.contact_id',
            DB::raw("'invoice' as mode"),
            "purchases.purchase_no as vno",
            'purchases.purchase_date as vdate',
            'purchases.grand_total',
            DB::raw("'' as transaction_amount"),
            DB::raw("'' as chq_no"),
        ])
            ->where('contact_id', '=', $party)
            ->whereBetween('purchase_date', [$start_date, $end_date])
            ->where('company_id', '=', session()->get('company_id'))
            ->union($purchase)
            ->orderBy('vdate')
            ->orderBy('mode')->get();
    }
}
