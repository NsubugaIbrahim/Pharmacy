@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Suppliers'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Suppliers</h6>
                            <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm ms-auto">Add Supplier</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Contact</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Address</th>
                                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $supplier->name }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $supplier->contact }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">{{ $supplier->address }}</td>
                                        <td class="align-middle text-sm ps-4 text-center">
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete this supplier?')">
                                                    Delete
                                                </button>
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