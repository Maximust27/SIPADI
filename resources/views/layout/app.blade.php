<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPADI - Sistem Posyandu Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F9FAFB; color: #374151; }
        .chart-container { position: relative; width: 100%; max-width: 600px; margin: 0 auto; height: 300px; max-height: 400px; }
        @media (min-width: 768px) { .chart-container { height: 350px; } }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); }
        .status-badge { padding: 0.25rem 0.75rem; border-radius: 9999px; font-weight: 600; font-size: 0.75rem; }
        .status-stunting { background-color: #FEE2E2; color: #B91C1C; }
        .status-normal { background-color: #D1FAE5; color: #047857; }
        /* Logic Nav Active Laravel */
        .nav-active { border-bottom: 2px solid #0D9488; color: #0D9488; font-weight: 600; }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="w-8 h-8 bg-teal-600 rounded-full flex items-center justify-center text-white font-bold">S</div>
                        <span class="font-bold text-xl tracking-tight text-teal-900">SIPADI</span>
                    </div>
                </div>
                <div class="flex space-x-4 items-center overflow-x-auto">
                    <!-- Menggunakan Route Laravel -->
                    <a href="{{ route('dashboard') }}" class="nav-item px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'nav-active' : 'text-gray-500 hover:text-teal-600' }}">Beranda</a>
                    <a href="{{ route('input') }}" class="nav-item px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('input') ? 'nav-active' : 'text-gray-500 hover:text-teal-600' }}">Input Data</a>
                    <a href="{{ route('register') }}" class="nav-item px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('register') ? 'nav-active' : 'text-gray-500 hover:text-teal-600' }}">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-auto">
        <div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-400">© 2025 SIPADI - Inovasi Akar Rumput untuk Indonesia Emas. Laravel Version.</p>
        </div>
    </footer>

</body>
</html>