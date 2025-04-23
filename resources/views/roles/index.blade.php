@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Drugs'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Roles</h6>
                            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm ms-auto">Add Role</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Description</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $role->name }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $role->description }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

        @include('layouts.footers.auth.footer')
@endsection