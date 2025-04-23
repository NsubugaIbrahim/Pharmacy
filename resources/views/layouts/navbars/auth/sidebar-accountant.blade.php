<head>
    <style>
    #sidenav-collapse-main {
    height: 60%;
    overflow-y: auto; /* Enables scrolling if needed */
    }

    .navbar-nav .nav-item .nav-link:hover {
        background-color: rgba(199, 199, 199, 0.2);
        border-radius: 0.5rem;
        transition: all 0.15s ease;
        transform: translateY(-1px);
        box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
        
    .navbar-nav .nav-item .nav-link:hover .icon-shape {
        transform: scale(1.1);
        transition: all 0.15s ease;
    }

    .navbar-nav .nav-item .nav-link:hover .nav-link-text {
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .collapsed .arrow-icon {
        transform: rotate(0deg);
        transition: transform 0.3s ease;
    }

    .nav-link:not(.collapsed) .arrow-icon {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    .nav-link.dropdown-toggle::after {
        display: none !important;
    }

    .submenu {
        list-style: none;
        padding-left: 0;
    }
    </style>
</head>
<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('home') }}" target="_blank">
            <img src={{ asset('img/life.png') }} class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ env('APP_NAME') }}</span><br>
            <span class="ms-1 font-weight-bold align-items-center">Accountant</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'finances' ? 'active' : '' }}" href="{{ route('finances') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-money-bill-wave text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'approve.stock.orders' ? 'active' : '' }}" href="{{ route('approve.stock.orders') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-hourglass-half text-success text-sm me-2" style ="margin-left: 30px"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pending Stock Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'sales.show' ? 'active' : '' }}" href="{{ route('sales.show') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bag-17 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sales</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'profile' ? 'active' : '' }}" href="{{ route('profile') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profile</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3" style="margin-top: 0px;">
        <div class="card card-plain shadow-none" id="sidenavCard">
            <img class="w-50 mx-auto" src="/img/illustrations/icon-documentation-warning.svg" alt="sidebar_illustration">
            <div class="card-body text-center p-3 w-100 pt-0">
                <div class="docs-info">
                    <h6 class="mb-0">{{ env('APP_NAME') }}</h6>
                    <p class="text-xs font-weight-bold mb-0">Archive your info</p>
                </div>
            </div>
        </div>
    </div>
</aside>