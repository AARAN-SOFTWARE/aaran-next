<div x-data="{ checkAll : false }"
     class="overflow-hidden w-full overflow-x-auto rounded-md border border-neutral-300 ">

    <table {{$attributes->merge(['class' => 'w-full text-left text-sm text-neutral-500 '])}}>

        <thead
            class="border-b border-neutral-300 bg-neutral-200 text-sm text-neutral-500  text-center">
        <tr>
            @if(isset($table_header))
                {{$table_header}}
            @endif
        </tr>
        </thead>

        <tbody class="divide-y divide-neutral-300 dark:divide-neutral-700 text-center">
        @if(isset($table_body))
            {{$table_body}}
        @endif
        </tbody>
    </table>
</div>
