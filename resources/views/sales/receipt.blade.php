@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #receipt, #receipt * {
            visibility: visible;
        }

        #receipt {
            width: 58mm;
            font-size: 12px;
            margin: 0 auto;
        }

        .no-print {
            display: none !important;
        }

        table.receipt-table {
            width: 100%;
            border: 2px solid #000; /* Thick border */
            border-collapse: collapse;
        }

        table.receipt-table th,
        table.receipt-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: left;
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    }

    /* Same for screen */
    #receipt {
        width: 100mm;
        font-size: 12px;
        margin: 0 auto;
    }

    table.receipt-table {
        width: 100%;
        border: 2px solid #000; /* Thick border */
        border-collapse: collapse;
    }

    table.receipt-table th,
    table.receipt-table td {
        border: 1px solid #000;
        padding: 4px;
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }
</style>

<div class="container mt-3">
    <div class="card">
        <div class="card-body" id="receipt">
            <div class="text-center">
                <img src="{{ asset('img/life.png') }}" alt="Logo" style="max-width: 60px; margin-bottom: 5px;">
                <strong>{{ strtoupper(env('APP_NAME')) }}</strong><br>
                <p><strong>Receipt Number:</strong> {{ $data['receipt_number'] }}</p><br>
                <p>{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</p><br>
            </div>
            

            <hr>

            <p><strong>Customer:</strong> {{ $data['customer_name'] }}</p>


            <table class="receipt-table">
                <thead>
                    <tr>
                        <th class="text-center">Drug</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['items'] as $item)

                        <tr>
                            <td class="text-center">{{ $item['drug_name'] }}</td>
                            <td class="text-center">{{ $item['quantity'] }}</td>
                            <td class="text-center">{{ number_format($item['selling_price'], 0) }}</td>
                            <td class="text-center">{{ number_format($item['selling_price'] * $item['quantity'], 0) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td class="text-center"><strong>{{ number_format($data['total'], 0) }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-center mt-2">
                <p>Thank you!</p>
            </div>
        </div>

        <div class="text-center no-print mt-3">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Print Receipt</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-sm">Back to Sales</a>
        </div>
    </div>
</div>
@endsection