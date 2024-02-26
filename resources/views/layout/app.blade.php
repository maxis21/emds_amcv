<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- CSS Links -->

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }}">
    @yield('styles')

    <!-- Jquery -->
    <script src="{{ asset('js/jquery3.js') }}"></script>

</head>

<body>
    <header>
        <div class="top-content d-flex">
            <div class="img-logo d-flex">
                <a href="{{--route('goto.dashboard')--}}">
                    <img src="{{ asset('img/amcvLogo.png') }}" alt="AMCV Logo" style="width: 55px; height: 55px">
                </a>
            </div>
            <div class="top-text d-flex">
                <p>
                    <span class="fs-3 fw-2">A</span>DVENTIST
                    <span class="fs-3 fw-2">M</span>EDICAL
                    <span class="fs-3 fw-2">C</span>ENTER-
                    <span class="fs-3 fw-2">V</span>ALENCIA
                </p>
                <p class="brand-sys">Electronic Document Management System</p>
            </div>
        </div>
    </header>
    <div class="d-flex">
        <aside>

            @include('super_admin.sidenav')
        </aside>

        <main>
            <div class="container-fluid">
                @yield('body-content')
            </div>
        </main>
    </div>
    @include('modals.logout')

    @yield('scripts')


</body>

</html>