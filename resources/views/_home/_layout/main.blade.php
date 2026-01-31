<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/_home/home-costum.css', 'resources/js/_home/landing.js'])
    <title>Smart Sekolah | @yield('title', 'Beranda')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Lexend:wght@100..900&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{  asset('favicon.png') }}" type="image/x-icon">
  </head>
  <body class="body-landingpage">
    @yield('content')
              
    <!-- FOOTER SECTION -->
    @include('_home._layout.footer')
</body>
</html>