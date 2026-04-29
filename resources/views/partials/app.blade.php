<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Owner Dashboard') — VenueOS</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- FONTS --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />

    <style>
        .font-anton  { font-family: 'Anton', sans-serif; }
        .font-dm     { font-family: 'DM Sans', sans-serif; }
        .font-mono   { font-family: 'DM Mono', monospace; }

        body { font-family: 'DM Sans', sans-serif; }

        .nav-active {
            background: rgba(0,0,0,0.05);
            color: #0b3d0b !important;
            font-weight: 500;
        }

        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:4px; }

        .card-lift { transition: transform .18s, box-shadow .18s; }
        .card-lift:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.08); }

        .stat-num { font-family:'DM Mono', monospace; }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 min-h-screen">

    {{-- ===== SIDEBAR ===== --}}
    @include('partials.sidebar')

    {{-- ===== MAIN AREA ===== --}}
    <div class="ml-56 flex flex-col min-h-screen">

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6 lg:p-8">
            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>