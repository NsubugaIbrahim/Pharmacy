@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Drug'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Edit Drug</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('drugs.update', $drug->id) }}" method="POST">
                            @csrf @method('PUT')
                    
                            <div class="mb-3">
                                <label>Drug Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $drug->name }}" required>
                            </div>
                    
                            <button class="btn btn-primary">Update Drug</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection
