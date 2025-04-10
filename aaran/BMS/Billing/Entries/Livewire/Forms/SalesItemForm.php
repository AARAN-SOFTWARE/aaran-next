<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SalesItemForm extends Form
{
    #[Validate]
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
