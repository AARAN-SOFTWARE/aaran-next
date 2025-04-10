<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SalesForm extends Form
{
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
    public ?float  $total_taxable = null;
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
//            'company_id' => 'required|exists:companies,id',
            'contact_id' => 'required',
            'invoice_no' => 'required|integer|unique:sales,invoice_no',
            'invoice_date' => 'required|date',
            'order_id' => 'required',
            'billing_id' => 'required',
            'shipping_id' => 'required',
            'style_id' => 'required',
            'despatch_id' => 'required',
            'transport_id' => 'required',
            'transport_name' => 'required|string'
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
}
