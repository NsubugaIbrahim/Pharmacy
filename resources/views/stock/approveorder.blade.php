@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
  @include('layouts.navbars.auth.topnav', ['title' => 'Decide Stock Orders'])
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12 mx-auto">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <h6>Pending Stock Orders</h6>
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Id</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Date Issued</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Total Cost (UGX)</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supplier</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($stockOrders as $order)
                    <tr>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ $order->id }}</p>
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ $order->date }}</p>
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ number_format($order->total) }}</p>
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ $order->supplier->name }}</p>
                      </td>
                      <td class="text-center">
                        <span class="badge badge-sm bg-gradient-success" data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}" style="cursor: pointer;">View Order Details</span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <!-- Order Details Modals -->
                @foreach($stockOrders as $order)
                <div class="modal fade" id="orderDetailsModal{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel{{ $order->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title text-success" id="orderDetailsModalLabel{{ $order->id }}">Stock Order #{{ $order->id }}</h5> <hr>
                        <h5 class="modal-title text-danger" style="margin-left: 10px;">{{ $order->date}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="table-responsive">
                          <table class="table align-items-center mb-0">
                            <thead>
                              <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Drug</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price (UGX)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Cost (UGX)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              @forelse($order->orderItems as $item)
                              <tr data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}">
                                <td class="text-center">
                                  <p class="text-xs font-weight-bold mb-0">{{ $item->drug->name }}</p>
                                </td>
                                <td class="text-center">
                                  <p class="text-xs font-weight-bold mb-0">{{ $item->quantity }}</p>
                                </td>
                                <td class="text-center">
                                  <p class="text-xs font-weight-bold mb-0">{{ number_format($item->price) }}</p>
                                </td>
                                <td class="text-center">
                                  <p class="text-xs font-weight-bold mb-0">{{$item->quantity * $item->price}}</p>
                                </td>   
                                <td class="text-center">
                                  @if($order->reception)
                                    <span class="badge badge-sm bg-gradient-success">received</span>
                                  @else
                                    <span class="badge badge-sm bg-gradient-secondary">pending</span>
                                  @endif
                                </td>                     
                              </tr>
                              @empty
                              <tr>
                                <td colspan="5" class="text-center">
                                  <p class="text-sm font-weight-bold mb-0">No approved stock orders available</p>
                                  <p class="text-xs text-secondary mb-0">Stock orders must be approved before they can be received</p>
                                </td>
                              </tr>
                              @endforelse
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="ms-3 fw-bold" style = "margin-right:30px">
                            Total Amount: UGX  <span class="text-primary">{{ number_format($order->total) }}</span>
                        </div>
                        <div class="btn-group" role="group">
                          <button type="button" class="btn btn-sm btn-success" onclick="confirmApprove({{ $order->id }})">Approve</button>
                          <button type="button" class="btn btn-sm btn-danger ms-2" onclick="confirmDecline({{ $order->id }})">Decline</button>
                          <button type="button" class="btn btn-sm bg-gradient-secondary ms-2" data-bs-dismiss="modal">Close</button>
                        </div>
                          <!-- Hidden forms for submission -->
                        <form id="approveForm{{ $order->id }}" action="{{ route('stock.approve', $order->id) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <form id="declineForm{{ $order->id }}" action="{{ route('stock.decline', $order->id) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('layouts.footers.auth.footer')
  </div>

  <script>
    function confirmApprove(orderId) {
        Swal.fire({
            title: 'Approve Order?',
            text: "Are you sure you want to approve this stock order?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#5cb85c',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('approveForm' + orderId).submit();
                
                // Show processing message
                Swal.fire({
                    title: 'Processing!',
                    text: 'Approving the order...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    }
    
    function confirmDecline(orderId) {
        Swal.fire({
            title: 'Decline Order?',
            text: "Are you sure you want to decline this stock order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, decline it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('declineForm' + orderId).submit();
                
                // Show processing message
                Swal.fire({
                    title: 'Processing!',
                    text: 'Declining the order...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    }
    
    // Display success/error messages from session
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>

@endsection
