<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Forms\Sale;

use Livewire\Form;

class ItemForm extends Form
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
}
