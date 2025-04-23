<style>
  /* Hover effect for table rows */
  .table tbody tr {
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  .table tbody tr:hover {
    background-color: rgba(94, 114, 228, 0.1);
    transform: translateY(-1px);
    box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
  }
</style>

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Stock History'])
    <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12 mx-auto">
            <div class="card mb-4">
              <div class="card-header pb-0">
                  <div class="d-flex align-items-center">
                  <h6>Stock History</h6>
                  </div>
              </div>
              <div class="card-body px-0 pt-0 pb-2">
                <div class="table-striped table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead>
                      <tr>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Id</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supplier</th>
                        
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Total (UGX)</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Date</th>
                        <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($stockOrders as $order)
                      <tr data-bs-toggle="modal" data-bs-target="#orderDetailsModal{{ $order->id }}">
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->id }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->supplier->name }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ number_format($order->total) }}</p>
                        </td>
                        <td class="text-center">
                          <p class="text-xs font-weight-bold mb-0">{{ $order->date }}</p>
                        </td>
                        <td class="text-center">
                          @if($order->status == 'approved')
                            <span class="badge badge-sm bg-gradient-success">{{ $order->status }}</span>
                          @elseif($order->status == 'declined')
                            <span class="badge badge-sm bg-gradient-danger">{{ $order->status }}</span>
                          @else
                            <span class="badge badge-sm bg-gradient-secondary">pending</span>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Cost</th>
                            </tr>
                          </thead>
                            <tbody>
                              @foreach($order->stockEntries as $entry)
                                <tr>
                                  <td>
                                    <div class="d-flex px-2 py-1">
                                      <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $entry->drug->name ?? 'N/A' }}</h6>
                                      </div>
                                    </div>
                                  </td>
                                  <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $entry->quantity }}</p>
                                  </td>
                                  <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ number_format($entry->price) }}</p>
                                  </td>
                                  <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ number_format($entry->cost) }}</p>
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="ms-3 fw-bold" style = "margin-right:30px">
                          Total Amount: UGX  <span class="text-primary">{{ number_format($order->total) }}</span>
                        </div>
                        <div class="btn-group" role="group">                           
                          <button type="button" class="btn btn-sm bg-gradient-secondary ms-2" data-bs-dismiss="modal">Close</button>
                        </div>
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
  @include('layouts.footers.auth.footer')
</div>
@endsection
