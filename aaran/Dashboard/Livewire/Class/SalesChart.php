<?php

namespace Aaran\Dashboard\Livewire\Class;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Livewire\Component;

class SalesChart extends Component
{
    use TenantAwareTrait;
    public $monthlyTotals = [];

    public function mount():void
    {

        $this->monthlyTotals=$this->fetchMonthlyTotals();
    }

    public function fetchMonthlyTotals()
    {
        $currentYear = date('Y');
        $nextYear = (int)$currentYear + 1;

        // Define the start and end dates
        $startDate = "{$currentYear}-04-01"; // April 1st of the current year
        $endDate = "{$nextYear}-03-31"; // March 31st of the next year

        return Sale::on($this->getTenantConnection())->selectRaw('MONTH(invoice_date) as month, YEAR(invoice_date) as year, SUM(grand_total) as total')
            ->where('company_id', '=', session()->get('company_id'))
            ->whereBetween('invoice_date', [$startDate, $endDate]) // Filter for April to March
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

//        return [];

        // Static dummy data for testing (April to March format)
//        return collect([
//            ['month' => 4, 'total' => 15000],
//            ['month' => 5, 'total' => 18000],
//            ['month' => 6, 'total' => 22000],
//            ['month' => 7, 'total' => 17000],
//            ['month' => 8, 'total' => 21000],
//            ['month' => 9, 'total' => 25000],
//            ['month' => 10, 'total' => 23000],
//            ['month' => 11, 'total' => 19000],
//            ['month' => 12, 'total' => 27000],
//            ['month' => 1, 'total' => 16000],
//            ['month' => 2, 'total' => 14000],
//            ['month' => 3, 'total' => 20000],
//        ]);

    }

    public function render()
    {
        return view('dashboard::sales-chart')->layout('components.layouts.auth');
    }
}
