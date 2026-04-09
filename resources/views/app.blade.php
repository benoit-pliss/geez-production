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

        <div id="initial-loader" style="position:fixed;inset:0;display:flex;align-items:center;justify-content:center;background:#fff;z-index:9999;transition:opacity 0.4s ease;">
            <p style="font-size:2rem;font-weight:700;letter-spacing:0.15em;animation:pulse 1.5s ease-in-out infinite;">GEEZ</p>
        </div>
        <style>
            @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.3} }
        </style>

        <div id="app"></div>

<script src="https://kit.fontawesome.com/895b664c37.js" crossorigin="anonymous"></script>
    </body>
</html>
