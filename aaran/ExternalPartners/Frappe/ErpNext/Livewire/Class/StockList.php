<?php

namespace Aaran\ExternalPartners\Frappe\ErpNext\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\ExternalPartners\Frappe\ErpNext\Services\ErpNextService;
use Exception;
use Livewire\Component;

class StockList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    protected $erpNextService;

    // Dependency Injection of ErpNextService
    public function __construct()
    {
        $this->erpNextService = new ErpNextService();
    }
    public function getList()
    {
        try {
            $filters = [
                'fields' => '["name", "item_code", "item_name", "stock_uom"]'
            ];

            $url = $this->erpNextService->baseUrl . "/api/resource/Item";
            $response = $this->erpNextService->client()->get($url, $filters);

            return $this->erpNextService->handleResponse($response);
        } catch (Exception $e) {
            return $this->erpNextService->handleError($e);
        }
    }

    public function render()
    {
        return view('frappe::stock-list', [
            'list' => $this->getList()
        ]);
    }
}
