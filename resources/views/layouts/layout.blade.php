<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite('resources/js/app.js')
    @vite('resources/js/cookiecheck.js')
    <!-- Additional CSS and meta tags -->
</head>
<body>
<!-- Common header, navigation, or other components -->
<header>
    @yield('header')
</header>

<main>
    @yield('content')
</main>
<!-- Common footer, scripts, or other components -->
<footer>
    @yield('footer')
</footer>
</body>
</html>
