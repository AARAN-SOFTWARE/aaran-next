<?php

namespace Aaran\Core\Setup\Jobs;

use Aaran\Core\Tenant\Facades\TenantManager;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use livewire\Component;

class CreateTenantJob extends component
{
    public function createTenant($tenantId)
    {
        try {
            $this->dispatch('setup-progress', message: 'Starting...');
            sleep(1);
            $this->dispatch('setup-progress', message: 'Creating tables...');
            sleep(1);
            $this->dispatch('setup-progress', message: 'Setting permissions...');
            sleep(1);
            $this->dispatch('setup-progress', message: 'Setup completed!');
            dd('here');

            $tenant = Tenant::findOrFail($tenantId);

            Log::info("🚀 CreateTenant started for tenant: {$tenant->t_name}");

            // TenantManager::switchTenant($tenant);

            $this->createCommonTables();

            $this->dispatch('tenant-setup-progress', message: 'Tenant setup completed successfully!');
            Log::info("✅ CreateTenant completed for tenant: {$tenant->t_name}");
        } catch (\Throwable $e) {
            Log::error("CreateTenant failed: " . $e->getMessage());
        }
    }

    public function createCommonTables(): void
    {
        $tables = [
            'cities' => [],
            'districts' => [],
            'states' => ['state_code'],
            'pincodes' => [],
            'countries' => ['country_code', 'currency_symbol'],
            'hsncodes' => ['description'],
            'units' => ['description'],
            'categories' => [],
            'colours' => [],
            'sizes' => ['description'],
            'departments' => [],
            'transports' => ['vehicle_no'],
            'banks' => [],
            'receipt_types' => [],
            'gst_percents' => ['description'],
            'contact_types' => [],
            'payment_modes' => [],
            'transaction_types' => [],
            'account_types' => [],
        ];

        foreach ($tables as $tableName => $extraColumns) {
            Schema::connection('tenant')->create($tableName, function (Blueprint $table) use ($extraColumns) {
                $table->id();
                $table->string('vname')->unique();

                foreach ($extraColumns as $column) {
                    $table->string($column)->nullable();
                }

                $table->tinyInteger('active_id')->nullable();
            });

            $this->dispatch('tenant-setup-progress', 'Creating ' . $this->formatTableName($tableName) . ' table...');
        }
    }

    protected function formatTableName(string $name): string
    {
        return ucwords(str_replace('_', ' ', $name));
    }


}
