<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SalesItemForm extends Form
{

    public string $itemIndex = '';
    public string $po_no = '';
    public string $dc_no = '';
    public string $no_of_roll = '';
    public ?string $product_id = null;
    public string $product_name = '';
    public string $description = '';
    public ?string $colour_id = null;
    public string $colour_name = '';
    public ?string $size_id = null;
    public string $size_name = '';
    public mixed $qty = '';
    public mixed $price = '';
    public mixed $gst_percent = '';

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
