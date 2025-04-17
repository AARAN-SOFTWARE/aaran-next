<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Class\Sale;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public function create(): void
    {
        ini_set('max_execution_time', 3600);
        $this->redirect(route('sales.upsert', ['0']));
    }

    public function print($id): void
    {
        $this->redirect(route('sales.print', [$id]));
    }

    public function getList()
    {
        $this->sortField = 'invoice_no';

        return Sale::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) {
            return;
        }

        try {
            $connection = $this->getTenantConnection();

            // Delete related sale items
            DB::connection($connection)
                ->table('sale_items')
                ->where('sale_id', $this->deleteId)
                ->delete();

            // Delete the main sale record if it exists
            Sale::on($connection)->find($this->deleteId)?->delete();

        } catch (\Exception $e) {
            Log::error("Failed to delete sale_id {$this->deleteId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function render()
    {
        return view('entries::sale.index')->with([
            'list' => $this->getList()
        ]);
    }
}
