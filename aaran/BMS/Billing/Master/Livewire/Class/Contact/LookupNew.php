<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Contact;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Master\Models\Contact;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LookupNew extends Component
{
    use TenantAwareTrait;

    public $search = '';
    public $results = [];
    public $showDropdown = false;

    public function updatedSearch($value)
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        if (strlen(trim($value)) > 0) {
            $this->results = Contact::on($this->getTenantConnection())->where('name', 'like', '%' . $value . '%')
                ->orderBy('name')
                ->limit(10)
                ->get();
            $this->showDropdown = true;
        } else {
            $this->results = [];
            $this->showDropdown = false;
        }
    }

    public function showDropdown()
    {
        $this->showDropdown = true;
    }

    public function hideDropdown()
    {
        // Delay hiding to allow click on results
        usleep(200000); // 200ms
        $this->showDropdown = false;
    }

    public function selectContact($id)
    {
        $contact = Contact::on($this->getTenantConnection())->find($id);
        if ($contact) {
            $this->search = $contact->name;
            $this->results = [];
            $this->showDropdown = false;
        }
    }

    public function render()
    {
        return view('master::contact.lookup-new');
    }
}
