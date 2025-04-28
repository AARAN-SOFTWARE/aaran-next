<strong>Pending Payments:</strong><br>
@forelse ($invoices as $invoice)
    • Invoice #{{ $invoice->id }} — Amount: ${{ number_format($invoice->amount, 2) }} (Due {{ $invoice->due_date->format('d M Y') }})<br>
@empty
    You have no pending payments. 🎉
@endforelse
