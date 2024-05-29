<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Exploreaza Romania</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name', 'Laravel')}}</title>
        @vite([
            'resources/js/app.js',
            'public/assets/bootstrap-5.1.3-dist/css/bootstrap.min.css',
            'public/assets/css/jquery-ui.min.css',
            'public/assets/css/app.css',
        ])
        @if (Auth::guard('tourist')->check())
            @vite(['resources/js/custom/tourist.js'])
        @elseif(Auth::guard('host')->check())
            @vite(['resources/js/custom/host.js'])
        @endif
    </head>
    <body>
        @if (Auth::guard('tourist')->check() || Auth::guard('host')->check())
            @include('layout.userHeader')
        @else
            @include('layout.mainHeader')
        @endif
        @yield('content')
        @include('layout.footer')
    </body>
</html>