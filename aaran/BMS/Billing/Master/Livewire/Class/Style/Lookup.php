<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Style;

use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Lookup extends Component
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
                ->table('styles')
                ->where('id', $initId)
                ->value('vname');

            if ($vname) {
                $this->search = $vname;
            }
        } else {
            $this->search = '';
        }
    }


    public string $searchText = '';

    public function updatedSearch($value): void
    {
        if (!$this->getTenantConnection()) {
            return;
        }

        $query = DB::connection($this->getTenantConnection())
            ->table('styles')
            ->select('id', 'vname')
            ->orderBy('vname');

        if (strlen(trim($value)) > 0) {
            $query->where('vname', 'like', '%' . $value . '%')->limit(10);
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
            $this->selectStyle($selected);
        }
    }

    public function selectStyle($style): void
    {
        $style = (object)$style;

        $this->search = $style->vname;
        $this->results = [];
        $this->showDropdown = false;
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-create-style-modal', name: $this->search);
        $this->showCreateModal = true;
    }

    #[On('refresh-style')]
    public function refreshStyle($style): void
    {
        $this->search = $style['vname'];
        $this->showCreateModal = false;
    }


    public function render()
    {
        return view('master::style.lookup');
    }
}
