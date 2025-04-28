<strong>New Products:</strong><br>
@forelse ($products as $product)
    • {{ $product->name }} (Added: {{ $product->created_at->format('d M') }})<br>
@empty
    No new products added recently.
@endforelse
