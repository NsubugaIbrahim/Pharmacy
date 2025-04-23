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
                    <h6>Expiry Alerts</h6>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                  <div class="table-striped table-responsive">
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Drug Name</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Stock ID</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Quantity</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Expiry date</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Time to expiry</th>                         
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $today = new DateTime();
                          $oneMonthLater = (new DateTime())->modify('+1 month');
                        @endphp
                        
                        @foreach($expiringDrugs as $stock)
                          @php
                            $expiryDate = new DateTime($stock->expiry_date);
                            $interval = $today->diff($expiryDate);
                            $daysToExpiry = $interval->days;
                            $expired = $today > $expiryDate;
                            
                            // Set row color based on expiry status
                            $rowClass = '';
                            if($expired) {
                              $rowClass = 'bg-success text-white';
                            } elseif($daysToExpiry <= 7) {
                              $rowClass = 'bg-secondary text-white';
                            } elseif($daysToExpiry <= 30) {
                              $rowClass = 'bg-light';
                            }
                          @endphp
                          
                          <tr class="{{ $rowClass }}">
                            <td class="text-center">
                              <p class="text-sm font-weight-bold mb-0">{{ $stock->drug->name }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-sm font-weight-bold mb-0">{{ $stock->id }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-sm font-weight-bold mb-0">{{ $stock->quantity }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-sm font-weight-bold mb-0">{{ date('d M Y', strtotime($stock->expiry_date)) }}</p>
                            </td>
                            <td class="text-center">
                              @if($expired)
                                <span class="badge badge-sm bg-gradient-danger">Expired</span>
                              @else
                                <p class="text-sm font-weight-bold mb-0">{{ $daysToExpiry }} days</p>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                        
                        @if(count($expiringDrugs) == 0)
                          <tr>
                            <td colspan="5" class="text-center">
                              <p class="text-sm font-weight-bold mb-0">No drugs expiring within a month</p>
                            </td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      
    </div>
    @include('layouts.footers.auth.footer')
  @endsection
