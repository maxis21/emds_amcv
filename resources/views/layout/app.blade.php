<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- CSS Links -->
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }}">
</head>

<body>

    <header>
        @include('layout.topnav')
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