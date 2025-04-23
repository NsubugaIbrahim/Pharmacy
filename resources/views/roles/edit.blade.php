@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Role'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Edit Role</h6>
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

                        <form action="{{ route('roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Role Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $role->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Role Description</label>
                                <input type="text" class="form-control" name="description" id="description" value="{{ $role->description }}" required>
                            </div>

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Role</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection
