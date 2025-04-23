@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs 6'])
    //stock in a drug into my system
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Stock Drug</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('drugs.store') }}" method="POST">
                            @csrf
                            <div class="form-group">    
                                <label for="name">Drug Name</label>
                                <select type="text" class="form-control" name="name" id="name" required>
                                    @foreach ($drugs as $drug)
                                        <option value="{{ $drug->id }}">{{ $drug->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="supply_price">Supply Price (UGX)</label>
                                <input type="number" class="form-control" name="supply_price" id="supply_price" min="0" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="selling_price">Selling Price (UGX)</label>
                                <input type="number" class="form-control" name="selling_price" id="selling_price" min="0" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Stock Drug</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection