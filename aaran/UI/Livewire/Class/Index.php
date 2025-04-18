<?php

namespace Aaran\UI\Livewire\Class;

use Livewire\Component;

class Index extends Component
{
    public $blogs = [];

    public function render()
    {
        return view('templates::index');
    }

}
