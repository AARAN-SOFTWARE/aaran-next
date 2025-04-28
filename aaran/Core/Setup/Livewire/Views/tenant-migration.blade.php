<div>

    <x-Ui::loadings.loading/>

    <div class="font-roboto tracking-wider">
        <div class="bg-amber-100 py-18 px-26">
            <div class="text-4xl font-semibold">Setup for {{$tenant->t_name}}
            </div>
        </div>
    </div>


    <div class="mt-10 max-w-3xl mx-auto bg-white shadow-lg border border-neutral-200 rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Setup to "{{$tenant->t_name}}"</h2>
        <div class="border-b-2 border-orange-400">&nbsp;</div>

        <div class="grid grid-cols-2 divide-y divide-green-500 gap-y-3 py-2 px-3">
            <div>Database</div>
            <div>{{$tenant->db_name}}</div>

            <div>User</div>
            <div>{{$tenant->db_user}}</div>

            <div>Pass</div>
            <div>{{$tenant->db_pass}}</div>

            <div>&nbsp;</div>

        </div>

        <div class="flex justify-between mt-6">
            <button wire:click="createTenant" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
        </div>
    </div>

    <x-Ui::setup.alerts/>
    <x-Ui::setup.confetti-effect/>
</div>
