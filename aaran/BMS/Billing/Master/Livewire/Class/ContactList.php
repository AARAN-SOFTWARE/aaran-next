<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Master\Models\Contact;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ContactList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public $log;

    public function create(): void
    {
        $this->redirect(route('contacts.upsert', ['0']));
    }

    public function getObj($id)
    {
        if ($id) {
            $obj = Contact::find($id);
            $this->vid = $obj->id;
            return $obj;
        }
        return null;
    }

    public function deleteFunction($id): void
    {
        if ($id) {
            $tenantConnection = $this->getTenantConnection();

            // Fetch the contact record
            $obj = Contact::on($tenantConnection)->find($id);

            if ($obj) {
                // First delete related contact_details
                DB::connection($tenantConnection)
                    ->table('contact_details')
                    ->where('contact_id', $id)
                    ->delete();

                // Then delete the contact itself
                $obj->delete();

                $this->dispatch('notify', ...['type' => 'success', 'content' => 'Deleted Successfully',]);
            }
        }
    }


    public function getList()
    {
        return Contact::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('master::contact-list')->with([
            'list' => $this->getList(),
        ]);
    }
}
