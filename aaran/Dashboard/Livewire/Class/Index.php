<?php

namespace Aaran\Dashboard\Livewire\Class;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public $blogs = [];

    public function render()
    {
        return view('dashboard::index');
    }

}
