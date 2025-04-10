<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Contact;

use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class LookupNew extends Component
{
    use TenantAwareTrait;

    public $search = '';
    public $results = [];
    public $highlightIndex = 0;
    public $showDropdown = false;
    public $showCreateModal = false;

    public $initialContactId;

    public function mount($initialContactId = null): void
    {
        $this->initialContactId = $initialContactId;

        if ($initialContactId && $this->getTenantConnection()) {
            // Trigger updatedSearch with a contact name pulled via id
            $vname = DB::connection($this->getTenantConnection())
                ->table('contacts')
                ->where('id', $initialContactId)
                ->value('vname'); // fetch only the name

            if ($vname) {
                $this->search = $vname; // triggers updatedSearch automatically
            }
        } else {
            $this->search = ''; // triggers full preload
        }
    }


    public string $searchText = '';

    public function updatedSearch($value): void
    {
        if (!$this->getTenantConnection()) {
            return;
        }

        $query = DB::connection($this->getTenantConnection())
            ->table('contacts')
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
            $this->selectContact($selected);
        }
    }

    public function selectContact($contact): void
    {
        $contact = (object)$contact;

        $this->search = $contact->vname;
        $this->results = [];
        $this->showDropdown = false;
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

    #[On('refresh-contact')]
    public function refreshContact($contact): void
    {
        $this->search = $contact['vname'];
        $this->showCreateModal = false;
    }


    public function render()
    {
        return view('master::contact.lookup-new');
    }
}
