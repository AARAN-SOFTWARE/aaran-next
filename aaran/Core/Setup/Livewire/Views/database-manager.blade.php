<div>

    <x-Ui::loadings.loading/>

    <div class="font-roboto tracking-wider">
        <div class="bg-amber-100 py-18 px-26">
            <div class="text-4xl font-semibold">Database Manager
            </div>
        </div>
    </div>


    <div class="mt-10 max-w-3xl mx-auto bg-white shadow-lg border border-neutral-200 rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Artisan Command</h2>

        <div class="flex flex-col gap-3 mt-3">

            <button wire:click.prevent="clearView" class="bg-green-500 text-white px-4 py-2 rounded">View:clear</button>

            <button wire:click.prevent="runMigration" class="bg-green-500 text-white px-4 py-2 rounded">Migrate</button>

            <button wire:click.prevent="runMigrationRollBack" class="bg-green-500 text-white px-4 py-2 rounded">Migrate:rollback</button>

            <button wire:click.prevent="runMigrationFreshSeed" class="bg-green-500 text-white px-4 py-2 rounded">Migrate:fresh --seed</button>

            <button wire:click.prevent="storageLink" class="bg-green-500 text-white px-4 py-2 rounded">storage:link</button>

            <button wire:click.prevent="storageUnLink" class="bg-green-500 text-white px-4 py-2 rounded">Storage : unlink</button>

        </div>
    </div>
</div>
