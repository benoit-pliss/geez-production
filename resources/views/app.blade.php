<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Geez-Production</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>

        <div id="app">
            <router-view></router-view>
        </div>



        <script src="https://kit.fontawesome.com/895b664c37.js" crossorigin="anonymous"></script>
    </body>
</html>
