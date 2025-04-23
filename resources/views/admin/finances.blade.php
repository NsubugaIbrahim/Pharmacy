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
    
    .finance-card {
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(50, 50, 93, 0.1), 0 5px 8px rgba(0, 0, 0, 0.07);
      transition: all 0.3s;
    }
    
    .finance-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(50, 50, 93, 0.15), 0 10px 15px rgba(0, 0, 0, 0.1);
    }
    
    .revenue-card {
      background: linear-gradient(45deg, #4481eb, #04befe);
    }
    
    .cost-card {
      background: linear-gradient(45deg, #ff9a9e, #fad0c4);
    }
    
    .profit-card {
      background: linear-gradient(45deg, #43e97b, #38f9d7);
    }
    
    .finance-icon {
      font-size: 1.5rem;
      opacity: 0.8;
    }
    
    .finance-value {
      font-size: 1rem;
      font-weight: 700;
    }
    
    .finance-label {
      font-size: 0.9rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .expenses-card {
  background: linear-gradient(45deg, #fa709a, #fee140);
}

  </style>
  
  @extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
  
  @section('content')
      @include('layouts.navbars.auth.topnav', ['title' => 'Financial Dashboard'])
      <div class="container-fluid py-4">
          <div class="row mb-4">
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card finance-card revenue-card text-white">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="finance-label mb-0">Total Revenue</p>
                                        <h5 class="finance-value mb-0">
                                            UGX {{ number_format($totalRevenue) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="finance-icon">
                                        <i class="ni ni-money-coins"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card finance-card cost-card text-white">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="finance-label mb-0">Cost of Goods</p>
                                        <h5 class="finance-value mb-0">
                                            UGX {{ number_format($totalCost) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="finance-icon">
                                        <i class="ni ni-cart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card finance-card expenses-card text-white">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="finance-label mb-0">Drugs Losses</p>
                                        <h5 class="finance-value mb-0">
                                            UGX {{ number_format($disposedDrugsLosses ?? 0) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="finance-icon">
                                        <i class="ni ni-basket"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                    <div class="card finance-card profit-card text-white">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="finance-label mb-0">Gross Profit</p>
                                        <h5 class="finance-value mb-0">
                                            UGX {{ number_format($profit) }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="finance-icon">
                                        <i class="ni ni-chart-bar-32"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <!-- Financial Charts -->
          <div class="row">
              <div class="col-12">
                  <div class="card mb-4">
                      <div class="card-header pb-0">
                          <h6>Financial Performance</h6>
                      </div>
                      <div class="card-body">
                          <div class="chart">
                              <canvas id="financial-chart" class="chart-canvas" height="300"></canvas>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Profit Margin Analysis -->
          <div class="row">
              <div class="col-12">
                  <div class="card mb-4">
                      <div class="card-header pb-0">
                          <h6>Profit Margin Analysis</h6>
                      </div>
                      <div class="card-body px-0 pt-0 pb-2">
                          <div class="table-responsive p-0">
                              <table class="table align-items-center mb-0">
                                  <thead>
                                      <tr>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Period</th>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Revenue</th>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cost</th>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gross Profit</th>
                                          <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Margin %</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach($labels as $index => $label)
                                      <tr>
                                          <td>
                                              <div class="d-flex px-2 py-1">
                                                  <div class="d-flex flex-column justify-content-center">
                                                      <h6 class="mb-0 text-sm">{{ $label }}</h6>
                                                  </div>
                                              </div>
                                          </td>
                                         
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">UGX {{ number_format($revenueData[$index]) }}</p>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">UGX {{ number_format($costData[$index]) }}</p>
                                          </td>
                                          <td>
                                              <p class="text-xs font-weight-bold mb-0">UGX {{ number_format($profitData[$index]) }}</p>
                                          </td>
                                          <td>
                                              @php
                                                  $margin = $revenueData[$index] > 0 ? ($profitData[$index] / $revenueData[$index]) * 100 : 0;
                                              @endphp
                                              <div class="d-flex align-items-center">
                                                  <span class="text-xs font-weight-bold me-2">{{ number_format($margin, 1) }}%</span>
                                                  <div>
                                                      <div class="progress">
                                                          <div class="progress-bar bg-gradient-success" role="progressbar" 
                                                              aria-valuenow="{{ $margin }}" aria-valuemin="0" aria-valuemax="100" 
                                                              style="width: {{ min($margin, 100) }}%;"></div>
                                                      </div>
                                                  </div>
                                              </div>
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
      </div>
    @include('layouts.footers.auth.footer')
      
      @push('js')
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById('financial-chart').getContext('2d');
            
            var labels = @json($labels);
            var revenueData = @json($revenueData);
            var costData = @json($costData);
            var profitData = @json($profitData);
            
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Revenue',
                            data: revenueData,
                            backgroundColor: 'rgba(66, 135, 245, 0.7)',
                            borderColor: 'rgba(66, 135, 245, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Cost',
                            data: costData,
                            backgroundColor: 'rgba(255, 99, 132, 0.7)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Profit',
                            data: profitData,
                            backgroundColor: 'rgba(75, 192, 192, 0.7)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            // Remove the type: 'line' to make it a bar chart like the others
                            // type: 'line',
                            // Remove fill: false as it's not needed for bar charts
                            // fill: false,
                            // Remove tension as it's not needed for bar charts
                            // tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'UGX ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': UGX ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    // Add barPercentage to control the width of the bars
                    barPercentage: 0.8,
                    // Add categoryPercentage to ensure equal spacing between groups
                    categoryPercentage: 0.9
                }
            });
        });
    </script>

      @endpush
  @endsection
