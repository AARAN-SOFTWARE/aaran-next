<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Contact;

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
            // Trigger updatedSearch with a contact name pulled via id
            $vname = DB::connection($this->getTenantConnection())
                ->table('contacts')
                ->where('id', $initId)
                ->value('vname'); // fetch only the name

            if ($vname) {
                $this->search = $vname; // triggers updatedSearch automatically
            }
        } else {
            $this->search = ''; // triggers full preload
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
            ->table('contacts')
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
            $this->selectContact($selected);
        }
    }

    public function selectContact($contact): void
    {
        $contact = (object)$contact;

        $this->search = $contact->vname;
        $this->results = [];
        $this->showDropdown = false;
        $this->dispatch('refresh-contact', $contact->id);
        $this->dispatch('refresh-billing-lookup', $contact);
        $this->dispatch('refresh-shipping-lookup', $contact);
        $this->dispatch('refresh-billing', $contact->id);
        $this->dispatch('refresh-shipping', $contact->id);
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-create-contact-modal', name: $this->search);
        $this->showCreateModal = true;
    }

    public function render()
    {
        return view('master::contact.lookup');
    }
}
