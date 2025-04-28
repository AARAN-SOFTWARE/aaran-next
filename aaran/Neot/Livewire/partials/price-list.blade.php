<strong>Price List:</strong><br>
@foreach ($products as $product)
    • {{ $product->vname }}: ${{ number_format($product->initial_price, 2) }}<br>
@endforeach
