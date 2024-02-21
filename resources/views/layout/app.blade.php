<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- CSS Links -->
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    <header>
        @include('layout.topnav')
    </header>
    <div class="d-flex">
        <aside>
            @include('layout.sidenav')
        </aside>

        <main>
            <div class="container-fluid">
                @yield('body-content')
            </div>
        </main>
    </div>

    @yield('scripts')
</body>

</html>