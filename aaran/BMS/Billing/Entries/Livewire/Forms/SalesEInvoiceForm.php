<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SalesEInvoiceForm extends Form
{
    #[Validate]
    public $e_invoiceDetails;
    public $e_wayDetails;
    public $token;
    public $irnData;
    public $IrnCancel;
    public $sales_id;
    public $Irn_no;
    public $CnlRsn;
    public $CnlRem;

    public mixed $qty;

    #region[rules]
    public function rules(): array
    {
        return [
            'transport_name' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'Vehno.required' => 'The :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'Vehno' => 'Vechile no',
        ];
    }
    #endregion
}
