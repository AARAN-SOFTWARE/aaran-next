<?php

namespace Aaran\Website\Livewire\Class;

use Aaran\Assets\Helper\SlideQuotes;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{

    public $slides = [];

    public function mount(): void
    {
        $this->slides = SlideQuotes::all();
    }


    public $features = [
        [
            'title' => 'Payroll',
            'description' => "Keep track of everyone's salaries and whether or not they've been paid.",
            'image' => '/images/slider/home/bg_1.webp',
        ],
        [
            'title' => 'GST handling',
            'description' => "We support companies that don’t deal with VAT — so technically we do all they need.",
            'image' => '/images/slider/home/bg_3.webp',
        ],
        [
            'title' => 'Claim expenses',
            'description' => "All your receipts organized — just type them in by hand.",
            'image' => '/images/slider/home/bg_2.webp',
        ],

        [
            'title' => 'Reporting',
            'description' => "Export everything into Excel and take control.",
            'image' => '/images/slider/home/bg_4.webp',
        ],
    ];


    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        return view('website::index');
    }

}
