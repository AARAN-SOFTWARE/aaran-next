<?php

namespace Aaran\Core\Setup\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RunTenantMigrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $t_name;

    public function __construct($name)
    {
        $this->t_name = $name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $logFile = storage_path('logs/migration_logs/' . $this->t_name . '.log');

        // Make sure directory exists
        if (!File::exists(dirname($logFile))) {
            File::makeDirectory(dirname($logFile), 0755, true);
        }

        // Clear previous logs
        File::put($logFile, "Starting migration for : {$this->t_name}...\n");

        // Now set the log channel dynamically
        Config::set('logging.channels.migration_logs', [
            'driver' => 'single',
            'path' => $logFile,
            'level' => env('LOG_LEVEL', 'debug'),
        ]);

        // Log to the custom channel
        Log::channel('migration_logs')->info("Starting artisan command...");

        $input = Artisan::call('aaran:migrate', [
            'tenant' => $this->t_name,
            '--fresh' => true,
            '--seed' => true,
        ]);

        $output = Artisan::output();

        // Log the migration output to the custom log channel
        Log::channel('migration_logs')->info("Migration output for tenant {$this->t_name}: {$output}");

        // Mark migration completion
        Log::channel('migration_logs')->info("Migration completed for tenant: {$this->t_name}");

        session()->flash('success', '🎉 Tenant created successfully!');
    }
}
