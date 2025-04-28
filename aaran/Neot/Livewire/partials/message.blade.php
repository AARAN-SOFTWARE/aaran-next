@if($results->isEmpty())
    <p>No records found.</p>
@else
    <div class="space-y-4">
        @foreach ($results as $item)
            <div class="bg-white shadow p-4 rounded-lg">
                @foreach ($columnMappings as $dbColumn => $displayName)
                    <div class="flex justify-between py-1">
                        <div class="text-gray-500">{{ $displayName }}</div>
                        <div class="font-semibold text-gray-700">
                            {{ data_get($item, $dbColumn) }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
@endif
