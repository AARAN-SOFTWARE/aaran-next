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

    #region[create]
    public function create(): void
    {
        ini_set('max_execution_time', 3600);
        $this->redirect(route('sales.upsert', ['0']));
    }
    #endregion

    #region[getObj]
    public function getObj($id)
    {
        if ($id) {
            $obj = Sale::find($id);
            $this->common->vid = $obj->id;
            return $obj;
        }
        return null;
    }
    #endregion

    #region[trashData]
    public function trashData(): void
    {
        $obj = $this->getObj($this->common->vid);
        DB::table('saleitems')->where('sale_id', '=', $this->common->vid)->delete();
        $obj->delete();
        $this->showDeleteModal = false;
        $message = "Deleted Successfully";
        $this->dispatch('notify', ...['type' => 'success', 'content' => $message]);
    }
    #endregon

    #region[print]
    public function print($id): void
    {
        $this->redirect(route('sales.print', [$id]));
    }
    #endregion


    #region[getList]
    public function getList()
    {
        $this->sortField = 'invoice_no';

        return Sale::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[Delete]
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

    #endregion


    #region[render]
    public function render()
    {
        return view('entries::sales.index')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
