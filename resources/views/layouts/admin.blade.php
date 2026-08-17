<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/pttun logo.png') }}">

    <title>@yield('title') | SIAP SIDANG</title>

    <!-- Style Bootstrap & Fonts Tetap Aman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Poppins, sans-serif;
        }
    </style>

    <!-- Memuat JS Laravel Echo/Reverb SAJA (tidak memuat CSS app agar Bootstrap tidak tumpang tindih) -->
    @vite(['resources/js/app.js'])
</head>

<body>

    <!-- Navbar kamu yang membedakan tampilan Admin & User tetap dipanggil di sini -->
    @include('layouts.navbar')

    @yield('content')

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Wadah untuk listener real-time WebSocket -->
    @stack('scripts')

</body>

</html>