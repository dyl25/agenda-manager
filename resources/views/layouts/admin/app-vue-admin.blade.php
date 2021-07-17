<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.title') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body>

    <main>
        <div id="app">
            <router-view></router-view>
        </div>
    </main>

</body>

</html>