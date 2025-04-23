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
      @include('layouts.navbars.auth.topnav', ['title' => 'Expired Drugs'])
      <div class="container-fluid py-4">
          <div class="row">
            <div class="col-12 mx-auto">
              <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                    <h6>Expired Drugs</h6>
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
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Drug Name</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Stock ID</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Quantity</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Expiry date</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Days Expired</th>
                          <th class="text-uppercase text-secondary text-xs text-center font-weight-bolder opacity-7">Actions</th>                         
                        </tr>
                      </thead>
                      <tbody>
                        @php
                          $today = new DateTime();
                        @endphp
                        
                        @foreach($expiredDrugs as $stock)
                          @php
                            $expiryDate = new DateTime($stock->expiry_date);
                            $interval = $expiryDate->diff($today);
                            $daysExpired = $interval->days;
                          @endphp
                          
                          <tr class="bg-light bg-opacity-10">
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
                              <span class="badge badge-sm bg-gradient-warning">{{ $daysExpired }} days</span>
                            </td>
                            <td class="text-center p-0">
                                <div class="d-flex justify-content-center align-items-center" style="height: 100%; margin-top:15px">
                                  <form action="{{ route('dispose.drug', $stock->id) }}" method="POST" id="dispose-form-{{ $stock->id }}">
                                    @csrf
                                    <button type="button" class="badge badge-sm bg-gradient-danger dispose-btn" data-id="{{ $stock->id }}">
                                      <i class="fas fa-trash-alt me-1"></i> Dispose
                                    </button>
                                  </form>
                                </div>
                            </td>
                          </tr>
                        @endforeach
                        
                        @if(count($expiredDrugs) == 0)
                          <tr>
                            <td colspan="6" class="text-center">
                              <p class="text-sm font-weight-bold mb-0">No expired drugs found</p>
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
    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const disposeBtns = document.querySelectorAll('.dispose-btn');
            
            disposeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const stockId = this.getAttribute('data-id');
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure you want to dispose of this drug?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, dispose it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('dispose-form-' + stockId).submit();
                        }
                    });
                });
            });
        });
    </script>
    @endpush

  @endsection
