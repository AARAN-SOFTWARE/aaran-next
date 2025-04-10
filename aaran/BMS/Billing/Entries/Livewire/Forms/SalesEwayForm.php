<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SalesEwayForm extends Form
{
    #[Validate]
    public mixed $qty;
    public $Transid;
    public $Transname;
    public $Transdocno;
    public $TransdocDt;
    #[validate]
    public $Vehno;
    public $Vehtype;
    public $TransMode;
    public $term;
    #endregion

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
