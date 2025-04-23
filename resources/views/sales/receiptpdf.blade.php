<!DOCTYPE html>
<html>
<head>
    <title>Receipt #{{ $receipt->receipt_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        h1, h3 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .total {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ strtoupper(env('APP_NAME')) }}</h1>
        <h3>Receipt #{{ $receipt->receipt_number }}</h3>
        <p>Customer: {{ $receipt->customer_name }}</p>
        <p>Date: {{ $receipt->created_at->format('Y-m-d H:i') }}</p>

        <table>
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
        </table>

        <div class="total">
            <p><strong>Total: {{ number_format($total) }}</strong></p>
        </div>
    </div>
</body>
</html>
