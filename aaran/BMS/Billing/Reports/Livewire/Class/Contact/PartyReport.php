<?php

namespace Aaran\BMS\Billing\Reports\Livewire\Class\Contact;

use Aaran\Assets\Trait\CommonTraitNew;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\Entries\Models\Purchase;
use Aaran\Entries\Models\Sale;
use Aaran\Transaction\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PartyReport extends Component
{
    use CommonTraitNew;
    #region[properties]
    public $byParty;
    public $byOrder;
    public $start_date;
    public $end_date;
    public mixed $opening_balance = '0';
    public mixed $sale_total = 0;
    public mixed $receipt_total = 0;
    public mixed $invoiceDate_first = '';
    #endregion

    #region[mount]
    public function mount($id)
    {
        $this->byParty = $id;
    }
    #endregion

    #region[opening_balance]
    public function opening_Balance()
    {
        if ($this->byParty) {
            $obj = Contact::find($this->byParty);
            $this->opening_balance = $obj->opening_balance;

            $this->invoiceDate_first = Carbon::now()->subYear()->format('Y-m-d');

            $this->sale_total = Sale::whereDate('invoice_date', '<', $this->start_date?:$this->invoiceDate_first)
                ->where('contact_id','=',$this->byParty)
                ->sum('grand_total');

            $this->receipt_total = Transaction::whereDate('vdate', '<', $this->start_date?:$this->invoiceDate_first)
                ->where('contact_id','=',$this->byParty)
                ->where('mode_id','=',111)
                ->sum('vname');

            $this->opening_balance = $this->opening_balance + $this->sale_total - $this->receipt_total;
        }
        return $this->opening_balance;
    }
    #endregion

    #region[List]
    public function getList()
    {
        $this->opening_Balance();
        $receipt = Transaction::select([
            'transactions.company_id',
            'transactions.contact_id',
            DB::raw("'receipt' as mode"),
            "transactions.id as vno",
            'transactions.vdate as vdate',
            DB::raw("'' as grand_total"),
            'transactions.vname',
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $this->byParty)
            ->where('mode_id', '=', 111)
            ->whereDate('vdate', '>=', $this->start_date ?: $this->invoiceDate_first)
            ->whereDate('vdate', '<=', $this->end_date ?: Carbon::now()->format('Y-m-d'))
            ->where('company_id', '=', session()->get('company_id'));

        $payment = Transaction::select([
            'transactions.company_id',
            'transactions.contact_id',
            DB::raw("'payment' as mode"),
            "transactions.id as vno",
            'transactions.vdate as vdate',
            DB::raw("'' as grand_total"),
            'transactions.vname',
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $this->byParty)
            ->where('mode_id','=',110)
            ->whereDate('vdate', '>=', $this->start_date ?: $this->invoiceDate_first)
            ->whereDate('vdate', '<=', $this->end_date ?: carbon::now()->format('Y-m-d'))
            ->where('company_id', '=', session()->get('company_id'));

        $purchase = Purchase::select([
            'purchases.company_id',
            'purchases.contact_id',
            DB::raw("'Purchase Invoice' as mode"),
            "purchases.purchase_no as vno",
            'purchases.purchase_date as vdate',
            'purchases.grand_total',
            DB::raw("'' as transaction_amount"),
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $this->byParty)
            ->whereDate('purchase_date', '>=', $this->start_date ?: $this->invoiceDate_first)
            ->whereDate('purchase_date', '<=', $this->end_date ?: Carbon::now()->format('Y-m-d'))
            ->where('company_id', '=', session()->get('company_id'));

        $salesInvoice = Sale::select([
            'sales.company_id',
            'sales.contact_id',
            DB::raw("'Sales Invoice' as mode"),
            "sales.invoice_no as vno",
            'sales.invoice_date as vdate',
            'sales.grand_total',
            DB::raw("'' as transaction_amount"),
        ])
            ->where('active_id', '=', 1)
            ->where('contact_id', '=', $this->byParty)
            ->whereDate('invoice_date', '>=', $this->start_date ?: $this->invoiceDate_first)
            ->whereDate('invoice_date', '<=', $this->end_date ?: Carbon::now()->format('Y-m-d'))
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

    #endregion

    public function print()
    {
        if ($this->byParty != null) {
            $this->redirect(route('contactReport.print',
                [
                    'party' => $this->byParty, 'start_date' => $this->start_date ?: $this->invoiceDate_first,
                    'end_date' => $this->end_date ?: Carbon::now()->format('Y-m-d'),
                ]));
        }
    }
    public function render()
    {
        return view(   'reports::Contact.party-report')->with([
            'list' => $this->getList()
        ]);
    }
}
