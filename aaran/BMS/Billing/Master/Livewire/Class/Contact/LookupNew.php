<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Contact;

use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LookupNew extends Component
{
    use TenantAwareTrait;

    public $search = '';
    public $results = [];
    public $highlightIndex = 0;
    public $showDropdown = false;

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


    public function updatedSearch($value)
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

        $this->results = $query->get();
        $this->highlightIndex = 0;
        $this->showDropdown = true;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex < count($this->results) - 1) {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex > 0) {
            $this->highlightIndex--;
        }
    }

    public function selectHighlighted()
    {
        $selected = $this->results[$this->highlightIndex] ?? null;
        if ($selected) {
            $this->selectContact($selected);
        }
    }

    public function selectContact($contact)
    {
        $contact = (object)$contact;

        $this->search = $contact->vname;
        $this->results = [];
        $this->showDropdown = false;

        $this->dispatch('refresh-contact', id: $contact->id);
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function render()
    {
        return view('master::contact.lookup-new');
    }
}
