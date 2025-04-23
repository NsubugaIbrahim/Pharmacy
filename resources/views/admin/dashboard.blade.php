@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Daily Revenue</p>
                                    <h5 class="font-weight-bolder">
                                    UGX {{ number_format($todayRevenue ?? 0, 0) }}
                                    </h5>
                                    <p class="mb-0">
                                    {{ \Carbon\Carbon::today()->toFormattedDateString() }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Weekly Customers</p>
                                    <h5 class="font-weight-bolder">
                                    {{ number_format($weeklyPatients) }}
                                    </h5>
                                    <p class="mb-0">
                                    {{ Carbon\Carbon::now()->startOfWeek()->format('M d') }} - {{ \Carbon\Carbon::now()->endOfWeek()->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Expired Drugs</p>
                                    <h5 class="font-weight-bolder">
                                    {{ number_format($monthlyExpiredDrugs) }}
                                    </h5>
                                    <p class="mb-0">
                                    {{ \Carbon\Carbon::now()->startOfMonth()->format('M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">MONTHLY SALES</p>
                                    <h5 class="font-weight-bolder">
                                    {{ number_format($monthlySales) }}
                                    </h5>
                                    <p class="mb-0">
                                    {{ Carbon\Carbon::now()->startOfMonth()->format('M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card z-index-2 h-100">
                    <div class="card-header pb-0 pt-3 bg-transparent">
                        <h6 class="text-capitalize">MONTHLY SALES</h6>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card card-carousel overflow-hidden h-100 p-0">
                    <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner border-radius-lg h-100">
                            <div class="carousel-item h-100 active" style="background-image: url('{{ asset('img/pham3.jpg') }}'); background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Least stock by drug</h5>
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Drug Name</th>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($lowStockDrugs as $drug)
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-sm text-white">{{ $drug->drug_name }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p class="text-xs font-weight-bold mb-0 text-white">{{ $drug->total_quantity }}</p>
                                                        </td>
                                                        <td class="align-middle text-center text-sm ">
                                                            @if($drug->total_quantity <= 0)
                                                                <span class="badge badge-sm bg-gradient-danger">Out of Stock</span>
                                                            @elseif($drug->total_quantity < 50)
                                                                <span class="badge badge-sm bg-gradient-warning">Low Stock</span>
                                                            @else
                                                                <span class="badge badge-sm bg-gradient-success">In Stock</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            <p class="text-xs font-weight-bold mb-0 text-white">No drugs with low stock found</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item h-100" style="background-image: url('{{ asset('img/pham2.jpg') }}'); background-size: cover;">
                                <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                    <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                        <i class="ni ni-bulb-61 text-dark opacity-10"></i>
                                    </div>
                                    <h5 class="text-white mb-1">Closest expiry dates by drug</h5>
                                    <div class="table-responsive">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Drug</th>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Expiry Date</th>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Days Left</th>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($soonExpiringDrugs as $inventory)
                                                @php
                                                    $daysLeft = Carbon\Carbon::now()->diffInDays($inventory->expiry_date, false);
                                                    $statusClass = $daysLeft < 7 ? 'bg-gradient-danger' : ($daysLeft < 14 ? 'bg-gradient-warning' : 'bg-gradient-info');
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm text-white">{{ $inventory->drug->name }}</h6>
                                                               
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0 text-white">{{ Carbon\Carbon::parse($inventory->expiry_date)->format('M d, Y') }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0 text-white">{{ $daysLeft }} days</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-xs font-weight-bold mb-0">{{ $inventory->quantity }}</p>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="badge badge-sm {{ $statusClass }}">
                                                            @if($daysLeft < 7)
                                                                Critical
                                                            @elseif($daysLeft < 14)
                                                                Warning
                                                            @else
                                                                Expiring Soon
                                                            @endif
                                                        </span>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <p class="text-sm mb-0">No drugs expiring within the next month</p>
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        
                                        @if(count($soonExpiringDrugs) > 0)
                                        <div class="text-center mt-3">
                                            <a href="{{ route('near.expiry') }}" class="btn btn-sm btn-outline-primary">View All Soon Expiring Drugs</a>
                                        </div>
                                        @endif
                                    </div>
                                    
                                        
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next w-5 me-3" type="button"
                            data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-7 mb-lg-0 mb-4">
                <div class="card ">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-2">Top selling drugs by quantity</h6>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Drug</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Quantity Sold</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Revenue</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Last Sale</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSellingDrugs as $sale)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $sale->drug->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $sale->drug->category }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $sale->total_quantity }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">UGX {{ number_format($sale->total_revenue) }}</p>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">{{ $sale->latest_sale->format('M d, Y') }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <h6 class="mb-0">Expired Drugs</h6>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            @forelse($expiredDrugs as $inventory)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="icon icon-shape icon-sm me-3 bg-gradient-danger shadow text-center">
                                            <i class="ni ni-ambulance text-white opacity-10"></i>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">{{ $inventory->drug->name }}</h6>
                                            <span class="text-xs">Expired on: <span class="font-weight-bold">{{ Carbon\Carbon::parse($inventory->expiry_date)->format('M d, Y') }}</span></span>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                            <i class="ni ni-bold-right" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <h6 class="mb-1 text-dark text-sm">No expired drugs found</h6>
                                        </div>
                                    </div>
                                </li>
                            @endforelse
                            
                            @if(count($expiredDrugs) > 0)
                                <li class="list-group-item border-0 d-flex justify-content-center ps-0 border-radius-lg">
                                    <a href="{{ route('expired.drugs') }}" class="btn btn-outline-primary btn-sm mb-0">View All Expired Drugs</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
    const chartLabels = {!! json_encode($labels) !!};
    const chartData = {!! json_encode($totals) !!};

        var ctx1 = document.getElementById("chart-line").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: chartLabels,
                datasets: [{
            label: "Daily Sales",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#fb6340",
            backgroundColor: gradientStroke1,
            borderWidth: 3,
            fill: true,
            data: chartData,
            maxBarThickness: 6
        }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        beginAtZero: true,
    grid: {
        drawBorder: false,
        display: true,
        drawOnChartArea: true,
        drawTicks: false,
        borderDash: [5, 5]
    },
    ticks: {
        callback: function(value) {
            return 'UGX ' + value;
        },
        display: true,
        padding: 10,
        color: '#666',
        font: {
            size: 12,
            family: "Open Sans",
            style: 'normal',
            lineHeight: 2
        }
    }
},
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    </script>
@endpush
