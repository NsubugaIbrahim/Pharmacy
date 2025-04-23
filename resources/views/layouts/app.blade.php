<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
        <link rel="icon" type="image/png" href="/img/life.png">
        <title>
            {{ env('APP_NAME') }} 
        </title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
        <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    </head>

    <body class="{{ $class ?? '' }}">

        @guest
            @yield('content')
        @endguest

        @auth
            @php
                $route = request()->route()->getName();
                $authRoutes = ['login', 'register'];
                $profileRoutes = ['profile-static'];
                $role = auth()->user()->role->name ?? '';
            @endphp

            @if (in_array($route, $authRoutes))
                @yield('content')
            @else
                @if (!in_array($route, $profileRoutes))
                    <div class="min-height-300 bg-primary position-absolute w-100"></div>
                @endif

                {{-- Load sidebar based on user role --}}
                @switch($role)
                    @case('admin')
                        @include('layouts.navbars.auth.sidebar-admin')
                        @break

                    @case('pharmacist')
                        @include('layouts.navbars.auth.sidebar-pharmacist')
                        @break

                    @case('medical-assistant')
                        @include('layouts.navbars.auth.sidebar-medical-assistant')
                        @break

                    @case('cashier')
                        @include('layouts.navbars.auth.sidebar-cashier')
                        @break

                    @case('accountant')
                        @include('layouts.navbars.auth.sidebar-accountant')
                        @break

                    @default
                        @include('layouts.navbars.auth.sidenav') {{-- Fallback sidebar --}}
                @endswitch

                <main class="main-content border-radius-lg">
                    @yield('content')
                </main>

                @include('components.fixed-plugin')
            @endif
        @endauth
        @yield('js')
        <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
        <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
                var options = {
                    damping: '0.5'
                }
                Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="assets/js/argon-dashboard.js"></script>
        @stack('js');
    </body>
</html>
