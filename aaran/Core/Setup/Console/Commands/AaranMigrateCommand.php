<?php

namespace Aaran\Core\Setup\Console\Commands;

use Aaran\Core\Tenant\Facades\TenantManager;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\ArrayInput;

class AaranMigrateCommand extends Command
{
    protected $signature = 'aaran:migrate {tenant} {--fresh} {--seed}';
    protected $description = 'Run migrations for a specific tenant without running default migrations.';

    public function handle()
    {
        $tenantName = $this->argument('tenant');

        $tenant = Tenant::where('t_name', $tenantName)->first();

        if (!$tenant) {
            $this->error("Tenant '{$tenantName}' not found.");
            return;
        }

        TenantManager::switchTenant($tenant);

        $this->info("Migrating for tenant: {$tenant->b_name}");

        // If `--fresh` is used, drop all tables before running migrations
        if ($this->option('fresh')) {
            $this->dropAllTables();
        }

        // List of migration directories (custom migrations only)
        $paths = [
            'aaran/BMS/Billing/Common/Database/Migrations',
            'aaran/BMS/Billing/Books/Database/Migrations',
            'aaran/BMS/Billing/Master/Database/Migrations',
            'aaran/BMS/Billing/Entries/Database/Migrations',
            'aaran/BMS/Billing/Transaction/Database/Migrations',
            'aaran/BMS/Billing/Transaction/Database/Migrations',
            'aaran/BMS/Baseline/Database/Migrations',
            'aaran/Dashboard/Database/Migrations',
            'aaran/Blog/Database/Migrations',
            'aaran/Neot/Database/Migrations',
        ];

        foreach ($paths as $row) {
            $path = realpath(base_path($row));

            if (!$path || !File::exists($path)) {
                $this->error("Migration folder not found: {$path}");
                continue;
            }

            $this->runMigration('migrate', $path);
        }

        // Run seeders if requested
        if ($this->option('seed')) {
            $this->runSeeder();
        }
    }

    private function dropAllTables()
    {
        $this->warn("Dropping all tables in the tenant database...");

        $database = config('database.connections.tenant.database');

        // Fetch all tables
        $tables = DB::connection('tenant')->select("SHOW TABLES");

        if (empty($tables)) {
            $this->info("No tables found in the database.");
            return;
        }

        // Build SQL to drop all tables
        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            $tableName = array_values((array) $table)[0]; // Get table name from the result
            DB::connection('tenant')->statement("DROP TABLE `$tableName`;");
        }

        DB::connection('tenant')->statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->info("All tables have been dropped successfully.");
    }

    private function runMigration(string $command, string $path)
    {
        if (!File::exists($path) || empty(File::files($path))) {
            $this->warn("No migrations found in folder '{$path}'.");
            return;
        }

        $input = [
            'command' => $command,
            '--database' => 'tenant',
            '--path' => str_replace(base_path(), '', $path), // Ensures only specific migrations run
            '--force' => true,
        ];

        $this->info("Running migrations from: {$path}");

        // Run Artisan command and stream output
        Artisan::handle(new ArrayInput($input), $this->output);
    }

    private function runSeeder()
    {
        $this->info("Seeding data...");

        $command = [
            'command' => 'db:seed',
            '--database' => 'tenant',
            '--class' => 'Aaran\Core\Setup\Database\Seeders\ClientSeeder',
            '--force' => true,
        ];

        // Run Artisan command and stream output
        Artisan::handle(new ArrayInput($command), $this->output);
    }
}
