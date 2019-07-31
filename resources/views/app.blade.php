<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ str_replace('_', ' ', config('app.name', 'Laravel')) }} • @yield('title')</title>
    <!-- Fav Icon -->
    <link rel="shortcut icon" href="{{ asset('logo_edunet.gif') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="wrapper">
            @if(Auth::check())
                @include('partials.sidebar')
            @endif
            <div class="container-fluid pl-0 pr-0">
                @if(Auth::check())
                    @include('partials.header')
                    @include('partials.alert')
                @endif
                <div id="content">
                    @yield('content')
                </div>
            </div>
        </div>
        @include('partials.footer')
    </div>
</body>
</html>
