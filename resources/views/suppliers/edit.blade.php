@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Supplier'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Edit Supplier</h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $supplier->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact" value="{{ $supplier->contact }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="{{ $supplier->address }}" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Supplier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection
