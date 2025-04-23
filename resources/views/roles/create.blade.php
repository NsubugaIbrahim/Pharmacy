@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Add Role'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="ccol-12 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Add New Role</h6>
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

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Role Description</label>
                                <input type="text" class="form-control" name="description" id="description" required>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection
