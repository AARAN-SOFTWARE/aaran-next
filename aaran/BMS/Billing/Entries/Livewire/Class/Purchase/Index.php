<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Class\Purchase;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public function create(): void
    {
        ini_set('max_execution_time', 3600);
        $this->redirect(route('purchases.upsert', ['0']));
    }

    public function print($id): void
    {
        $this->redirect(route('purchases.print', [$id]));
    }

    public function getList()
    {
        $this->sortField = 'entry_no';

        return Purchase::on($this->getTenantConnection())
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

            // Delete related purchase items
            DB::connection($connection)
                ->table('purchase_items')
                ->where('purchase_id', $this->deleteId)
                ->delete();

            // Delete the main purchase record if it exists
            Purchase::on($connection)->find($this->deleteId)?->delete();

        } catch (\Exception $e) {
            Log::error("Failed to delete purchase_id {$this->deleteId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function render()
    {
        return view('entries::purchase.index')->with([
            'list' => $this->getList()
        ]);
    }
}
