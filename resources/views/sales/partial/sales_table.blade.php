<div class="table-responsive">
    @if($sales->count())
    <table class="table table-hover table-striped sales-table align-middle">
        <thead style="background-color: {{ $headerColor ?? '#0d6efd' }}22; color: #000;"> {{-- 22 is ~14% opacity --}}
            <tr>
                <th>Invoice No</th>
                <th>Buyer</th>
                <th>TIN</th>
                <th>Currency</th>
                <th class="text-end">Total</th>
                <th>Date</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr class="sale-row">
                <td>{{ $sale->invoice_no }}</td>
                <td class="buyer">{{ $sale->buyer_register_name }}</td>
                <td>{{ $sale->buyer_tin ?? '—' }}</td>
                <td class="text-center">{{ $sale->receipt_currency }}</td>
                <td class="text-end fw-bold">{{ number_format($sale->receipt_total, 2) }}</td>
                <td>{{ $sale->receipt_date->format('Y-m-d H:i') }}</td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info" title="View">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('sales.print', $sale) }}" class="btn btn-sm btn-secondary" target="_blank" title="Print">
                            <i class="fas fa-print"></i> Print
                        </a>

                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this sale?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach

            <tr class="no-results" style="display:none;">
                <td colspan="7" class="text-center text-warning">No matching records found</td>
            </tr>
        </tbody>
    </table>
    @else
        <div class="text-center py-5">
            <h5 class="text-warning mb-2">No records found</h5>
            <p class="text-muted">Add sales to display records here.</p>
        </div>
    @endif
</div>

<style>
    .btn-group .btn {
        min-width: 60px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4px;
    }

    .sales-table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .sales-table th, .sales-table td {
        vertical-align: middle;
    }
</style>
