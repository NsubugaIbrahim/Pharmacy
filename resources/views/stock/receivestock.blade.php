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
  @include('layouts.navbars.auth.topnav', ['title' => 'Receive Stock'])
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12 mx-auto">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <div class="d-flex align-items-center">
                <h6>Receive Stock</h6> 
              </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-striped table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Id</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Date</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Total (UGX)</th>
                      <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Supplier</th>  
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
                        <p class="text-xs font-weight-bold mb-0">{{ $order->date }}</p>
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ number_format($order->total) }}</p>
                      </td>
                      <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ $order->supplier->name }}</p>
                      </td>   
                      <td class="text-center">
                        @if($order->reception)
                          <span class="badge badge-sm bg-gradient-success">received</span>
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
                      <form id="receiveStockForm{{ $order->id }}" action="{{ route('stock.update-expiry', $order->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                          <p class = "text-center text-info">Add the expiry dates for all the Drugs to be stocked before receiving</p>
                            <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Drug</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit Price</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Cost</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Selling Price</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Expiry date</th>
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
                                      <td>
                                        <input type="number" class="form-control" name="selling_prices[{{ $entry->id }}]" value="{{ $entry->selling_price }}" required>
                                      </td>
                                      <td>
                                        @if($order->reception)
                                          {{ $entry->expiry_date }}
                                        @else
                                          <input type="date" class="form-control" name="expiry_dates[{{ $entry->id }}]" required>
                                          <input type="hidden" name="entry_ids[]" value="{{ $entry->id }}">
                                        @endif
                                      </td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                      </div>
                      </div>
                      <div class="modal-footer">
                          <div class="ms-3 fw-bold" style="margin-right:30px">
                              Total Amount: UGX  <span class="text-primary">{{ number_format($order->total) }}</span>
                          </div>
                          <div class="btn-group" role="group">
                              @if($order->reception)
                                  <button type="submit" class="btn btn-sm bg-gradient-secondary" disabled>Already Received</button>
                              @else
                                  <button type="submit" class="btn btn-sm bg-gradient-success">Receive Stock</button>
                              @endif
                              <button type="button" class="btn btn-sm bg-gradient-secondary ms-2" data-bs-dismiss="modal">Cancel</button>
                          </div>
                      </div>
                  </form>
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

  <!-- SweetAlert2 Library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script>
      // Check for success message in session
      document.addEventListener('DOMContentLoaded', function() {
          @if(session('success'))
              Swal.fire({
                  title: 'Success!',
                  text: "{{ session('success') }}",
                  icon: 'success',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#5e72e4'
              });
          @endif
          
          @if(session('error'))
              Swal.fire({
                  title: 'Error!',
                  text: "{{ session('error') }}",
                  icon: 'error',
                  confirmButtonText: 'OK',
                  confirmButtonColor: '#f5365c'
              });
          @endif
          
          // Add event listeners to all receive stock forms
          @foreach($stockOrders as $order)
              @if(!$order->reception)
                  document.getElementById('receiveStockForm{{ $order->id }}').addEventListener('submit', function(e) {
                      e.preventDefault();
                      
                      // Check if all expiry dates are filled
                      let allFilled = true;
                      this.querySelectorAll('input[type="date"]').forEach(function(input) {
                          if (!input.value) {
                              allFilled = false;
                          }
                      });
                      
                      if (!allFilled) {
                          Swal.fire({
                              title: 'Error!',
                              text: 'Please fill in all expiry dates',
                              icon: 'error',
                              confirmButtonText: 'OK',
                              confirmButtonColor: '#f5365c'
                          });
                          return;
                      }
                      
                      // Show loading state
                      Swal.fire({
                          title: 'Processing...',
                          html: 'Please wait while we update the inventory',
                          allowOutsideClick: false,
                          didOpen: () => {
                              Swal.showLoading();
                          }
                      });
                      
                      // Submit the form
                      this.submit();
                  });
              @endif
          @endforeach
      });
  </script>
@endsection
