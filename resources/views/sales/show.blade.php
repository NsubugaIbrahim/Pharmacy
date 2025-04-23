@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sales Details'])
    <div class="container-fluid py-4">
      <div class="col-12 mx-auto">
        <div class="card mb-4">
          <div class="card-header pb-0">
              <div class="d-flex align-items-center">
              <h6>Sales Details</h6>
              </div>
          </div>
          
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif
          
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-striped table-responsive">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">No</th>
                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Drug Name</th>
                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Quantity</th>
                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Total Price</th>
                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Customer Name</th>
                    <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Sold At</th>                         
                  </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                        <tr class="bg-light bg-opacity-10">
                            <td class="text-center">
                                <p class="text-sm font-weight-bold mb-0">{{ $loop->iteration }}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bold mb-0">{{  $sale->drug->name ?? 'N/A' }}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bold mb-0">{{ $sale->quantity}}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bold mb-0">{{ number_format($sale->total_price, 2)  }}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bold mb-0">{{ $sale->customer_name  }}</p>
                            </td>
                            <td class="text-center">
                                <p class="text-sm font-weight-bold mb-0">{{ $sale->created_at->format('d M Y, h:i A')  }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No sales found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
</div> 
    @include('layouts.footers.auth.footer')
@endsection
