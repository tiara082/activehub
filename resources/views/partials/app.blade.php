<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ActiveHub</title>

    @if (app()->environment('production'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

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
    <div class="lg:ml-52 flex flex-col min-h-screen">

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-4 pt-[4.5rem] lg:pt-6 lg:p-8">
            @yield('content')
        </main>

    </div>

    @stack('scripts')

    {{-- GLOBAL TOAST NOTIFICATIONS --}}
    @if(session('success'))
        <div id="toast-success" class="fixed bottom-5 right-5 z-[100] flex items-center w-full max-w-sm p-4 space-x-3 text-gray-700 bg-white border border-gray-100 rounded-2xl shadow-xl transform transition-all duration-500 translate-y-0 opacity-100" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 bg-green-50 rounded-xl text-green-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <div class="ml-3 text-sm font-medium pr-2 flex-1">{{ session('success') }}</div>
            <button type="button" onclick="closeToast('toast-success')" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed bottom-5 right-5 z-[100] flex items-center w-full max-w-sm p-4 space-x-3 text-gray-700 bg-white border border-gray-100 rounded-2xl shadow-xl transform transition-all duration-500 translate-y-0 opacity-100" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 bg-red-50 rounded-xl text-red-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>
            <div class="ml-3 text-sm font-medium pr-2 flex-1">{{ session('error') }}</div>
            <button type="button" onclick="closeToast('toast-error')" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <script>
        function closeToast(id) {
            const toast = document.getElementById(id);
            if (toast) {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }
        }
        
        // Auto dismiss after 4 seconds
        setTimeout(() => {
            closeToast('toast-success');
            closeToast('toast-error');
        }, 4000);
    </script>
</body>
</html>