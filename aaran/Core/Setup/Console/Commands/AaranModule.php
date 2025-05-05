<?php

namespace Aaran\Core\Setup\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AaranModule extends Command
{
    protected $signature = 'aaran:module {name} {--path=} {--force} {--all}';
    protected $description = 'Generate a module skeleton using stubs';

    public function handle()
    {
        $name = $this->argument('name');
        $relativePath = $this->option('path') ?? '';
        $relativePath = trim(str_replace(['.', '\\'], DIRECTORY_SEPARATOR, $relativePath), DIRECTORY_SEPARATOR);

        $moduleName = Str::studly($name);
        $moduleLower = Str::lower($name);

        $basePath = base_path("aaran" . DIRECTORY_SEPARATOR . ($relativePath ? "$relativePath/" : '') . $moduleName);

        if (File::exists($basePath)) {
            if ($this->option('force')) {
                $this->line("Force overwriting the existing module at '{$basePath}'...");
                File::deleteDirectory($basePath); // Delete the existing module before creating a new one
            } else {
                $this->error("Module '{$moduleName}' already exists at '{$basePath}'. Use --force to overwrite.");
                return;
            }
        }

        $this->createDirectories($basePath);

        if ($this->option('all')) {
            $this->createAdvanceDirectories($basePath);
        }

        $this->createFilesFromStubs($basePath, $moduleName, $moduleLower);

        $this->info("Module '{$moduleName}' created successfully at '{$basePath}'.");
    }

    protected function createDirectories(string $basePath): void
    {
        $paths = [
            $basePath,
            "$basePath/Database/Migrations",
            "$basePath/Database/Factories",
            "$basePath/Database/Seeders",

            "$basePath/Livewire/Class",
            "$basePath/Livewire/Views",

            "$basePath/Models",
            "$basePath/Providers",

            "$basePath/Routes",

            "$basePath/Http/Controllers",
        ];

        foreach ($paths as $path) {
            File::makeDirectory($path, 0755, true);
        }
    }

    protected function createAdvanceDirectories(string $basePath): void
    {
        $paths = [
            $basePath,
            "$basePath/Config",
            "$basePath/Http/Controllers",
            "$basePath/Http/Middleware",
            "$basePath/Services",
            "$basePath/Tests/Feature",
            "$basePath/Tests/Unit",
        ];

        foreach ($paths as $path) {
            File::makeDirectory($path, 0755, true);
        }
    }


    protected function createFilesFromStubs(string $basePath, string $moduleName, string $moduleLower): void
    {
        $stubs = [
            'service-provider.stub' => "$basePath/Providers/{$moduleName}ServiceProvider.php",
            'route-provider.stub' => "$basePath/Providers/{$moduleName}RouteProvider.php",
            'web-routes.stub' => "$basePath/routes/web.php",
            'api-routes.stub' => "$basePath/routes/api.php",
        ];

        foreach ($stubs as $stubFile => $targetPath) {
            $stubPath = base_path("aaran/Core/Setup/Stubs/{$stubFile}");

            if (!File::exists($stubPath)) {
                $this->warn("Stub missing: {$stubPath}");
                continue;
            }

            $content = File::get($stubPath);
            $content = str_replace(
                ['{{moduleName}}', '{{moduleLower}}'],
                [$moduleName, $moduleLower],
                $content
            );

            File::put($targetPath, $content);
        }
    }
}
