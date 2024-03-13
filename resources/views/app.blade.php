<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ asset('favicon-geez.ico') }}">

        <title>Geez-Production</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full">

        <div id="app">
            <router-view></router-view>
        </div>

        <!-- Umami -->
        <script defer src="https://analytics.eu.umami.is/script.js" data-website-id="dae1e59b-eb64-4764-b0b6-2be23f661401"></script>

        <script src="https://kit.fontawesome.com/895b664c37.js" crossorigin="anonymous"></script>
    </body>
</html>
