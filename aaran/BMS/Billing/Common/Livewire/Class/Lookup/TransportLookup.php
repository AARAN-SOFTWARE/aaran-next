<?php

namespace Aaran\BMS\Billing\Common\Livewire\Class\Lookup;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\Transport;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class TransportLookup extends Component
{
    use TenantAwareTrait;

    public $search = '';
    public $results = [];
    public $highlightIndex = 0;
    public $showDropdown = false;
    public $showCreateModal = false;

    public $initId;

    public function mount($initId = null): void
    {
        $this->initId = $initId;

        if ($initId && $this->getTenantConnection()) {

            $vname = DB::connection($this->getTenantConnection())
                ->table('transports')
                ->where('id', $initId)
                ->value('vname');

            if ($vname) {
                $this->search = $vname;
            }
        } else {
            $this->search = '';
        }
    }


    public function updatedSearch(): void
    {
        $this->searchBy();
    }
    public function searchBy(): void
    {
        if (!$this->getTenantConnection()) {
            return;
        }

        $query = DB::connection($this->getTenantConnection())
            ->table('transports')
            ->select('id', 'vname')
            ->orderBy('vname');

        if (strlen(trim($this->search)) > 0) {
            $query->where('vname', 'like', '%' . $this->search . '%')->limit(10);
        }
        $results = $query->get();

        $this->results = $results;
        $this->highlightIndex = 0;
        $this->showDropdown = true;
    }

    public function incrementHighlight(): void
    {
        if ($this->highlightIndex < count($this->results) - 1) {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight(): void
    {
        if ($this->highlightIndex > 0) {
            $this->highlightIndex--;
        }
    }

    public function selectHighlighted(): void
    {
        $selected = $this->results[$this->highlightIndex] ?? null;
        if ($selected) {
            $this->selectTransport($selected);
        }
    }

    public function selectTransport($transport): void
    {
        $transport = (object)$transport;

        $this->search = $transport->vname;
        $this->results = [];
        $this->showDropdown = false;
        $this->dispatch('refresh-transport', $transport->id);
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function createNew(): void
    {
        $transport = Transport::on($this->getTenantConnection())->create([
            'vname' => $this->search,
            'active_id' => 1
        ]);
        $this->dispatch('refresh-transport', $transport->id);
        $this->dispatch('notify', ...['type' => 'success', 'content' => $this->search. '- Transport Saved Successfully']);
        $this->showDropdown = false;
    }

    #[On('refresh-transport-lookup')]
    public function refreshSize($transport): void
    {
        if (!empty($transport['vname'])) {
            $this->search = $transport['vname'];
            $this->showCreateModal = false;
        } else {
            $this->search = '';
        }
    }

    public function render()
    {
        return view('common::lookup.transport-lookup');
    }
}
