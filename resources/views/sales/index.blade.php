@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sales'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Sales</h6>
                    </div>
                    <div class="card-body">
                        {{-- Alerts --}}
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Add Drug to Cart Form --}}
                        <form method="GET" action="{{ route('sales.index') }}" class="mb-4">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="drug_id" class="form-label">Select Drug:</label>
                                    <select name="drug_id" class="form-control" id="drug_id" required>
                                        <option value="">Select Drug</option>
                                        @foreach($drugs as $drug)
                                            <option value="{{ $drug->id }}">
                                                {{ $drug->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" name="quantity" class="form-control" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="selling_price" class="form-label">Selling Price:</label>
                                    <input type="number" step="0.01" name="selling_price" id="selling_price" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" formaction="{{ route('sales.store') }}" formmethod="POST" class="btn btn-primary">
                                        @csrf
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        {{-- Display Cart --}}
                        @php $cart = session('cart', []); @endphp
                        @if(count($cart) > 0)
                            <h5>Cart Items</h5>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>Drug Name</th>
                                        <th>Quantity</th>
                                        <th>Price per unit</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach(session('cart') as $index => $item)
                                        <tr>
                                            <td>{{ $item['drug_name'] }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>{{ number_format($item['selling_price'], 2) }}</td>
                                            <td>{{ number_format($item['selling_price'] * $item['quantity'], 2) }}</td>
                                            <td>
                                                <a href="{{  route('sales.cart.remove', $index) }}" class="btn btn-danger btn-sm">Remove</a>
                                            </td>
                                        </tr>
                                        @php $total += $item['selling_price'] * $item['quantity']; @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold">Total</td>
                                        <td class="fw-bold">{{ number_format($total, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- Finalize Sale --}}
                            <form method="POST" action="{{ route('sales.checkout') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Customer Name:</label>
                                    <input type="text" name="customer_name" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success">Finalize Sale</button>
                            </form>
                        @else
                            <p class="text-muted">Your cart is empty.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('layouts.footers.auth.footer')
@endsection

@section('js')
    <script>
        document.getElementById('drug_id').addEventListener('change', function () {
            let drugId = this.value;
            console.log('Selected Drug ID:', drugId); // 🔍 DEBUG

            if (drugId) {
                fetch(`/get-selling-price/${drugId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Fetched Price Data:', data); // 🔍 DEBUG
                        if (data.selling_price !== undefined) {
                            document.getElementById('selling_price').value = data.selling_price;
                        } else {
                            document.getElementById('selling_price').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching price:', error);
                        document.getElementById('selling_price').value = '';
                    });
            } else {
                document.getElementById('selling_price').value = '';
            }
        });
    </script>
@endsection


