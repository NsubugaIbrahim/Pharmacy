@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style>
@media print {
    /* Reset page margins for printing */
    body, html {
        margin: 0;
        padding: 0;
        font-size: 10px; /* Reduce font size for printing */
    }

    .container-fluid, .card {
        padding: 0;
        margin: 0;
        width: 100%; /* Full width for printing */
    }

    .card-header {
        padding: 5px 10px;
        font-size: 12px; /* Smaller font for card header */
    }

    .card-body {
        padding: 5px 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 5px;
        font-size: 10px; /* Smaller font size for table content */
        text-align: left;
    }

    table th {
        background-color: #f8f9fa;
    }

    tfoot th {
        text-align: right;
    }

    .table-bordered {
        border: 1px solid #ddd;
    }

    /* Hide navigation and header for printing */
    .navbar, .footer {
        display: none;
    }

    /* Hide the no-print class during printing */
    .no-print {
        display: none;
    }

    /* Set page size for receipt printer */
    @page {
        size: 80mm 200mm; /* Customize this size for your receipt printer */
        margin: 0;
    }
}
</style>
@include('layouts.navbars.auth.topnav', ['title' => 'Receipt Review'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header">
            <img src="{{ asset('img/life.png') }}" alt="Logo" style="max-width: 60px; margin-bottom: 5px;">
            <strong>{{ strtoupper(env('APP_NAME')) }}</strong><br>
            <h5 class="mb-0">Receipt #{{ $receipt->receipt_number }}</h5>
            <p>Customer: <strong>{{ $customer_name }}</strong></p>
            <p>Date: {{ $receipt->created_at->format('Y-m-d H:i') }}</p>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->drug->name ?? '-' }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ number_format($sale->unit_price) }}</td>
                            <td>{{ number_format($sale->total_price) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>{{ number_format($total) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-center no-print mt-3">
                <button onclick="window.print()" class="btn btn-primary btn-sm">Print Receipt</button>
                <a href="{{ route('sales.history') }}" class="btn btn-secondary btn-sm">Back to History</a>
            </div>
        </div>
    </div>
</div>
@endsection
