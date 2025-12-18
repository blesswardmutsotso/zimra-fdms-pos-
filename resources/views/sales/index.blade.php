@extends('layouts.app')

@section('title', 'All Invoices')

@section('content')
<div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4 gap-3">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-file-invoice text-primary mr-2"></i> Sales & Notes
    </h1>
    
</div>

<div class="mb-3">
    <input type="text" id="searchInput" class="form-control" placeholder="Search by buyer or invoice no">
</div>

<div class="card shadow border-0">
    <div class="card-body">

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="salesTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active text-dark" id="receipt-tab" data-bs-toggle="tab" data-bs-target="#receipt" type="button" role="tab" aria-controls="receipt" aria-selected="true" data-color="#0d6efd">
                    Fiscal Receipts
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="credit-tab" data-bs-toggle="tab" data-bs-target="#credit" type="button" role="tab" aria-controls="credit" aria-selected="false" data-color="#198754">
                    Fiscal Credit Notes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link text-dark" id="debit-tab" data-bs-toggle="tab" data-bs-target="#debit" type="button" role="tab" aria-controls="debit" aria-selected="false" data-color="#dc3545">
                    Fiscal Debit Notes
                </button>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content" id="salesTabContent">
            @php
                $receipts = $sales->where('receipt_type', 'FiscalInvoice');
                $creditNotes = $sales->where('receipt_type', 'FiscalCreditNote');
                $debitNotes = $sales->where('receipt_type', 'FiscalDebitNote');
            @endphp

            <div class="tab-pane fade show active" id="receipt" role="tabpanel" aria-labelledby="receipt-tab">
                @include('sales.partial.sales_table', ['sales' => $receipts, 'headerColor' => '#0d6efd'])
            </div>

            <div class="tab-pane fade" id="credit" role="tabpanel" aria-labelledby="credit-tab">
                @include('sales.partial.sales_table', ['sales' => $creditNotes, 'headerColor' => '#198754'])
            </div>

            <div class="tab-pane fade" id="debit" role="tabpanel" aria-labelledby="debit-tab">
                @include('sales.partial.sales_table', ['sales' => $debitNotes, 'headerColor' => '#dc3545'])
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const tabButtons = document.querySelectorAll('#salesTabs .nav-link');

    // Function to update active tab color
    function setActiveTabColor(activeTab) {
        tabButtons.forEach(tab => tab.style.backgroundColor = '');
        activeTab.style.backgroundColor = activeTab.dataset.color;

        // Update table header background to match active tab
        const activePaneId = activeTab.getAttribute('data-bs-target');
        document.querySelectorAll('.sales-table thead').forEach(thead => {
            thead.style.backgroundColor = '';
            thead.style.color = '';
        });
        const activeTableThead = document.querySelector(activePaneId + ' .sales-table thead');
        if(activeTableThead){
            activeTableThead.style.backgroundColor = activeTab.dataset.color;
            activeTableThead.style.color = '#fff';
        }
    }

    // Apply color when a tab is shown
    tabButtons.forEach(tab => {
        tab.addEventListener('shown.bs.tab', (e) => {
            setActiveTabColor(e.target);
        });
    });

    // Initialize first tab color
    setActiveTabColor(document.querySelector('#salesTabs .nav-link.active'));

    // Filter rows across all tables
    function filterTables() {
        const query = searchInput.value.trim().toLowerCase();
        document.querySelectorAll('.sales-table').forEach(table => {
            let visibleRows = 0;
            table.querySelectorAll('tbody tr.sale-row').forEach(row => {
                const buyer = row.querySelector('.buyer').textContent.toLowerCase();
                const invoice = row.children[0].textContent.toLowerCase();
                if(buyer.includes(query) || invoice.includes(query)) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });
            const noResults = table.querySelector('.no-results');
            if(noResults) noResults.style.display = visibleRows ? 'none' : '';
        });
    }

    searchInput.addEventListener('keyup', filterTables);
</script>
@endsection
