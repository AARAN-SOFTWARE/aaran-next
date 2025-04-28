<?php

namespace Aaran\Core\Setup\Livewire\Class;

use Aaran\Core\Setup\Jobs\RunTenantMigrationJob;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Livewire\Component;

class DatabaseManager extends Component
{
    public function clearView(): void
    {
        Artisan::call('view:clear');
    }

    public function runMigration(): void
    {
        Artisan::call('migrate');
    }

    public function runMigrationRollBack(): void
    {
        Artisan::call('migrate:rollback');
    }


    public function runMigrationFreshSeed(): void
    {
        Artisan::call('migrate:fresh --seed');
    }

    public function storageLink(): void
    {
        Artisan::call('storage:link');
    }

    public function storageUnLink(): void
    {
        Artisan::call('storage:unlink');
    }

    #[Layout('Ui::components.layouts.web')]
    public function render()
    {
        return view('setup::database-manager');
    }
}
