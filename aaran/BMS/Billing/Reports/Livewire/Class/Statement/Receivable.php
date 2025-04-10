<?php

namespace Aaran\BMS\Billing\Reports\Livewire\Class\Statement;

use Aaran\Assets\Trait\CommonTraitNew;
use Aaran\BMS\Billing\Master\Models\Contact;
use Livewire\Component;

class Receivable extends Component
{

    use CommonTraitNew;

    public function getList()
    {
        return Contact::where('contact_type_id', '124')->get();
    }

    public function render()
    {
        return view('reports::Statement.receivable')->with([
            'list' => $this->getList(),
        ]);
    }
}
