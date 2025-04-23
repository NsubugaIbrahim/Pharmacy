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
      @include('layouts.navbars.auth.topnav', ['title' => 'Disposed Drugs'])
      <div class="container-fluid py-4">
          <div class="row">
            <div class="col-12 mx-auto">
              <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                    <h6>Disposed Drugs</h6>
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
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Days Expired</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Losses incurred</th>                         
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($disposedDrugs as $drug)
                          <tr>
                            <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $drug->drug_name }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $drug->stock_id }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $drug->quantity }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $drug->expiry_date }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ $drug->days_expired }}</p>
                            </td>
                            <td class="text-center">
                              <p class="text-xs font-weight-bold mb-0">{{ number_format($drug->losses_incurred) }}</p>
                            </td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="6" class="text-center">
                              <p class="text-xs font-weight-bold mb-0">No disposed drugs found</p>
                            </td>
                          </tr>
                        @endforelse
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
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
  @endsection
