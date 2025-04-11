<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Carbon\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SalesForm extends Form
{
    use TenantAwareTrait;

    public ?string $vid = null;

    public string $uniqueno = '';
    public string $acyear = '';
    public mixed $company_id;
    public mixed $contact_id = '';

    #[Validate]
    public string $invoice_no = '';
    public string $invoice_date = '';
    public string $sales_type = '';
    public string $order_id = '';
    public string $billing_id = '';
    public string $shipping_id = '';
    public string $style_id = '';
    public string $despatch_id = '';
    public string $job_no = '';
    public string $destination = '';
    public string $bundle = '';

    public string $distance = '';
    public string $trans_mode = '';
    public string $trans_id = '';
    public string $trans_name = '';
    public string $trans_docs = '';
    public string $trans_docs_dt = '';
    public string $veh_no = '';
    public string $veh_type = '';
    public string $term = '';


    public ?float $total_qty = null;
    public ?float $total_taxable = null;
    public ?float $total_gst = null;
    public mixed $ledger_id = '';
    public ?float $additional;
    public ?float $round_off = null;
    public ?float $grand_total = null;
    public mixed $received_by = '';
    public bool $active_id = true;

    #region[rules]
    public function rules(): array
    {
        return [
            'uniqueno' => 'required|string|max:255|unique:sales,uniqueno',
            'contact_id' => 'required',
            'invoice_no' => 'required|integer|unique:sales,invoice_no',
            'invoice_date' => 'required|date',
            'order_id' => 'required',
            'billing_id' => 'required',
            'shipping_id' => 'required',
            'style_id' => 'required',
            'despatch_id' => 'required',
            'trans_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contact_name.required' => 'The :attribute is required.',
            'transport_name.required' => 'The :attribute is required.',
            'distance.required' => 'The :attribute is required.',
            'Vehno.required' => 'The :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'contact_name' => 'party name',
            'transport_name' => 'transport name',
            'distance' => 'distance ',
            'Vehno' => 'Vechile no',
        ];
    }

    #endregion

    public function setDefaultValues(): void
    {
        $this->invoice_no = Sale::nextNo($this->getTenantConnection());
        $this->invoice_date = Carbon::now()->format('Y-m-d');
        $this->uniqueno = session()->get('company_id') . '~' . session()->get('acyear') . '~' . $this->invoice_no;
        $this->active_id = true;
        $this->sales_type = '1';
        $this->additional = 0;
        $this->grand_total = 0;
        $this->total_taxable = 0;
        $this->round_off = 0;
        $this->total_gst = 0;
        $this->trans_mode = 1;
        $this->veh_type = 'R';
        $this->trans_docs = $this->invoice_no;
        $this->trans_docs_dt = Carbon::now()->format('Y-m-d');
        $this->trans_name = '-';
        $this->veh_no = '-';
    }

    public function loadValues($obj): void
    {
        $this->vid = $obj->id;
        $this->uniqueno = $obj->uniqueno;
        $this->acyear = $obj->acyear;
        $this->company_id = $obj->company_id;
        $this->contact_id = $obj->contact_id;
        $this->invoice_no = $obj->invoice_no;
        $this->invoice_date = $obj->invoice_date;
        $this->sales_type = optional($obj->sales_type)->id;
        $this->order_id = $obj->order_id;
        $this->billing_id = $obj->billing_id;
        $this->shipping_id = $obj->shipping_id;
        $this->style_id = $obj->style_id;
        $this->despatch_id = $obj->despatch_id;
        $this->job_no = $obj->job_no;
        $this->destination = $obj->destination;
        $this->bundle = $obj->bundle;
        $this->distance = $obj->distance;
        $this->trans_mode = $obj->trans_mode;
        $this->trans_id = $obj->trans_id;
        $this->trans_name = $obj->trans_name;
        $this->trans_docs = $obj->trans_docs;
        $this->trans_docs_dt = $obj->trans_docs_dt;
        $this->veh_no = $obj->veh_no;
        $this->veh_type = $obj->veh_type;
        $this->term = $obj->term;

        $this->total_qty = $obj->total_qty;
        $this->total_taxable = $obj->total_taxable;
        $this->total_gst = $obj->total_gst;
        $this->ledger_id = $obj->ledger_id;
        $this->additional = $obj->additional;
        $this->round_off = $obj->round_off;
        $this->grand_total = $obj->grand_total;
        $this->received_by = $obj->received_by;
        $this->active_id = $obj->active_id;
    }


    public function createOrUpdate(): string
    {
        $this->validate();

        try {
            $sale = $this->vid
                ? Sale::on($this->getTenantConnection())->findOrFail($this->vid)
                : new Sale();

            $sale->uniqueno = $this->uniqueno;
            $sale->acyear = $this->acyear;
            $sale->company_id = $this->company_id;
            $sale->contact_id = $this->contact_id;
            $sale->invoice_no = $this->invoice_no;
            $sale->invoice_date = $this->invoice_date;
            $sale->sales_type = $this->sales_type;
            $sale->order_id = $this->order_id;
            $sale->billing_id = $this->billing_id;
            $sale->shipping_id = $this->shipping_id;
            $sale->style_id = $this->style_id;
            $sale->despatch_id = $this->despatch_id;
            $sale->job_no = $this->job_no;
            $sale->destination = $this->destination;
            $sale->bundle = $this->bundle;

            $sale->distance = $this->distance;
            $sale->trans_mode = $this->trans_mode;
            $sale->trans_id = $this->trans_id;
            $sale->trans_name = $this->trans_name;
            $sale->trans_doc = $this->trans_doc;
            $sale->trans_doc_dt = $this->trans_doc_dt;
            $sale->veh_no = $this->veh_no;
            $sale->veh_type = $this->veh_type;
            $sale->term = $this->term;

            $sale->total_qty = $this->total_qty;
            $sale->total_taxable = $this->total_taxable;
            $sale->total_gst = $this->total_gst;
            $sale->ledger_id = $this->ledger_id;
            $sale->additional = $this->additional;
            $sale->round_off = $this->round_off;
            $sale->grand_total = $this->grand_total;
            $sale->received_by = $this->received_by;
            $sale->active_id = $this->active_id;

            $sale->save();

            return 'success';

        } catch (\Exception $e) {
            logger()->error('Sale Save Error: ' . $e->getMessage());
            return $e->getMessage();
        }
    }


}
