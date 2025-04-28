<?php

namespace Aaran\Core\Setup\Livewire\Class;

use Aaran\Core\Setup\Jobs\RunTenantMigrationJob;
use Aaran\Core\Tenant\Models\Tenant;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TenantMigration extends Component
{
    public mixed $tenant;

    public function mount($id = null)
    {
        if ($id) {
            $this->tenant = Tenant::find($id);
        }
    }

    public function createTenant()
    {
        set_time_limit(300); // 5 minutes
        RunTenantMigrationJob::dispatchSync($this->tenant->t_name);
    }

    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        return view('setup::tenant-migration');
    }
}
