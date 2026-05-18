<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ActiveHub – Platform Cari Lapangan dan Teman Main</title>
    <meta name="description" content="Temukan lapangan olahraga terdekat, pesan langsung secara real-time, dan cari teman main di ActiveHub.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #ffffff;
            color: #1a2e0f;
            margin: 0;
        }

        .font-display, h1, h2, h3 {
            font-family: 'Bebas Neue', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('navbar')

    @include('landing.hero')
    @include('landing.features')
    @include('landing.public-matches')
    @include('landing.value')
    @include('landing.cta')

    @include('landing.footer')

    @stack('scripts')
</body>
</html>