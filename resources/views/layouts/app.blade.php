<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env("APP_NAME") }}</title>

    @vite('resources/css/app.css')


</head>

<body>
    <!-- content section -->
    @yield('content')

    @vite('resources/js/app.js')
</body>

</html>