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
            <span class="ms-1 font-weight-bold">{{ env('APP_NAME') }}</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('home') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ Route::currentRouteName() == 'stock.view' ? 'active' : 'collapsed' }}" href="#stockSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ Route::currentRouteName() == 'stock.view' ? 'true' : 'false' }}" aria-controls="stockSubmenu">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-archive-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Stock Management</span>
                    <i class="ni ni-bold-down ms-auto arrow-icon"></i>
                </a>
                @php
                    $stockRoutes = ['stock.index', 'stock.view', 'approve.stock.orders', 'receive.stock'];
                @endphp

                <ul class="collapse submenu {{ in_array(Route::currentRouteName(), $stockRoutes) ? 'show' : '' }}" id="stockSubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'stock.index' ? 'active' : '' }}" href="{{ route('stock.index') }}">
                            <i class="ni ni-box-2 text-info text-sm me-2" style ="margin-left: 30px"></i>
                            <span class="nav-link-text ms-1">Order New Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'approve.stock.orders' ? 'active' : '' }}" href="{{ route('approve.stock.orders') }}">
                            <i class="fas fa-hourglass-half text-success text-sm me-2" style ="margin-left: 30px"></i>
                            <span class="nav-link-text ms-1">Pending Stock Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'receive.stock' ? 'active' : '' }}" href="{{ route('receive.stock') }}">
                            <i class="ni ni-credit-card text-warning text-sm me-2" style ="margin-left: 30px"></i>
                            <span class="nav-link-text ms-1">Receive Stock</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'stock.view' ? 'active' : '' }}" href="{{ route('stock.view') }}">
                            <i class="fas fa-notes-medical text-danger text-sm me-2" style ="margin-left: 30px"></i>
                            <span class="nav-link-text ms-1">Stock History</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle {{ Route::currentRouteName() == 'stock.view' ? 'active' : 'collapsed' }}" 
                   href="#inventorySubmenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ Route::currentRouteName() == 'stock.view' ? 'true' : 'false' }}" aria-controls="inventorySubmenu">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-archive-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Inventory Management</span>
                    <i class="ni ni-bold-down ms-auto arrow-icon"></i>
                </a>
                <ul class="collapse submenu {{ Route::currentRouteName() == 'stock.show' ? 'show' : '' }}" id="inventorySubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'stock.show' ? 'active' : '' }}" href="{{ route('stock.show') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-store text-info text-sm opacity-10" style ="margin-left: 30px"></i>
                            </div>
                            <span class="nav-link-text ms-1">Inventory</span>
                        </a>
                    </li>
                </ul>
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
                <a class="nav-link dropdown-toggle {{ Route::currentRouteName() == 'near.expiry' ? 'active' : 'collapsed' }}" 
                   href="#expirySubmenu" data-bs-toggle="collapse" role="button" aria-expanded="{{ Route::currentRouteName() == 'near.expiry' ? 'true' : 'false' }}" aria-controls="expirySubmenu">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-exclamation-triangle text-danger text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Expiry Management</span>
                    <i class="ni ni-bold-down ms-auto arrow-icon"></i>
                </a>

                @php
                    $expiryRoutes = ['near.expiry', 'expired.drugs', 'disposed.drugs'];
                @endphp
                <ul class="collapse submenu {{ in_array(Route::currentRouteName(), $expiryRoutes) ? 'show' : '' }}" id="expirySubmenu">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'near.expiry' ? 'active' : '' }}" href="{{ route('near.expiry') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-clock text-info text-sm opacity-10" style ="margin-left: 30px"></i>
                            </div>
                            <span class="nav-link-text ms-1">Expiry Alerts</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'expired.drugs' ? 'active' : '' }}" href="{{ route('expired.drugs') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-exclamation-circle text-danger text-sm opacity-10" style ="margin-left: 30px"></i>
                            </div>
                            <span class="nav-link-text ms-1">Expired Drugs</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'disposed.drugs' ? 'active' : '' }}" href="{{ route('disposed.drugs') }}">
                            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-trash-alt text-warning text-sm opacity-10" style ="margin-left: 30px"></i>
                            </div>
                            <span class="nav-link-text ms-1">Disposed Drugs</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'finances' ? 'active' : '' }}" href="{{ route('finances') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-money-bill-wave text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Financial management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'drugs.index' ? 'active' : '' }}" href="{{ route('drugs.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-pills text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Drugs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'suppliers.index' ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-tags text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Supplier</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'sales.index' ? 'active' : '' }}" href="{{ route('sales.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shopping-cart text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Receive order</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'roles.index' ? 'active' : '' }}" href="{{ route('roles.index') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-circle-08 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'user-management' ? 'active' : '' }}" href="{{ route('user-management') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-bullet-list-67 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">User Management</span>
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