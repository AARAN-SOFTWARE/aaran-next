<?php

namespace Aaran\Website\Livewire\Class\Home;

use Aaran\Assets\Helper\SlideQuotes;
use Aaran\Core\Tenant\Models\Plan;
use Illuminate\Database\Query\Builder;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Billing extends Component
{

    public $plans;
    public function mount($id): void
    {
        if ($id){
            $this->plans = Plan::all();
        }

    }

    #[Layout('Ui::components.layouts.web')]
    public function render()
    {

        return view('website::home.billing');
    }

}
