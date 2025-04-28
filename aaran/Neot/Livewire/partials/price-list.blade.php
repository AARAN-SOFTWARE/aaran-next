@if($results->isEmpty())
    <p>No records found.</p>
@else
    <ul>
        @foreach ($results as $row)
            <li>
                @foreach ($row->toArray() as $column => $value)
                    <strong>{{ ucfirst($column) }}:</strong> {{ $value }}<br>
                @endforeach
            </li>
            <hr>
        @endforeach
    </ul>
@endif
