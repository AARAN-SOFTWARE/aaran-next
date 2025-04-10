<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Contact;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Master\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Lookup extends Component
{
    use TenantAwareTrait;

    public $contact_name = '';

    public $contact_id = '';
    public $contactCollection;
    public $highlightContact = 0;
    public $contactTyped = false;

    public function mount($id = null): void
    {
        $this->contact_id = $id;
    }

    public function decrementContact(): void
    {
        if ($this->highlightContact === 0) {
            $this->highlightContact = count($this->contactCollection) - 1;
            return;
        }
        $this->highlightContact--;
    }

    public function incrementContact(): void
    {
        if ($this->highlightContact === count($this->contactCollection) - 1) {
            $this->highlightContact = 0;
            return;
        }
        $this->highlightContact++;
    }

    public function setContact($name, $id): void
    {
        $this->contact_name = $name;
        $this->contact_id = $id;
    }

    public function enterContact(): void
    {
        $obj = $this->contactCollection[$this->highlightContact] ?? null;
        $this->highlightContact = 0;
        $this->contact_name = $obj->vname ?? '';
        $this->contact_id = $obj->id ?? '';
    }

    #[On('refresh-contact')]
    public function refreshContact($v): void
    {
        $this->contact_id = $v['id'];
        $this->contact_name = $v['vname'];
        $this->contactTyped = false;
    }

    public function getContactList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->contactCollection = DB::connection($this->getTenantConnection())
            ->table('contacts')
            ->when(trim($this->contact_name), fn($query) => $query->where('vname', 'like', '%' . trim($this->contact_name) . '%'))
            ->get();
    }

    public function render()
    {
        $this->getContactList();

        return view('master::contact.lookup');
    }
}
