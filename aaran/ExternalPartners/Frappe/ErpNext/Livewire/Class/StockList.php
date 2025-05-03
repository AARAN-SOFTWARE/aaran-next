<?php

namespace Aaran\ExternalPartners\Frappe\ErpNext\Livewire\Class;

use Aaran\ExternalPartners\Frappe\ErpNext\Services\ErpNextService;
use Exception;
use Livewire\Component;

class StockList extends Component
{
    public $selected = 'Wireless Mouse';
    public $stockData = [];

    protected ErpNextService $erpNextService;

    public function mount()
    {

        $this->getStockBalanceReport();
    }

    public function updatedSelected()
    {
        $this->getStockBalanceReport();  // Trigger report fetch on item change
    }


    public function getStockBalanceReport()
    {
        $this->erpNextService = new ErpNextService();

        try {
            $url = $this->erpNextService->baseUrl . "/api/method/frappe.desk.query_report.run";

            $response = $this->erpNextService->client()->get($url, [
                'report_name' => 'Stock Balance',
                'ignore_prepared_report' => 'True',
                'filters' => json_encode([
                    'item_group' => $this->selected,
                    'to_date' => '2025-01-03',
                ])
            ]);

            $this->stockData = $this->erpNextService->handleResponse($response)['message']['result'] ?? [];
        } catch (Exception $e) {
            $this->stockData = [];
            report($e); // optional: log the error
        }
    }

    public function render()
    {
        return view('frappe::stock-list');
    }
}
