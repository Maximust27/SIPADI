<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPADI - Sistem Posyandu Digital</title>
    
    <!-- Library Penting -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Font Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F3F4F6; }
        .animate-enter { animation: enter 0.6s ease-out forwards; opacity: 0; transform: translateY(20px); }
        @keyframes enter { to { opacity: 1; transform: translateY(0); } }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-gray-700">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center text-white font-bold group-hover:rotate-12 transition">S</div>
                        <span class="font-bold text-xl tracking-tight text-gray-800">SIPADI</span>
                    </a>
                </div>

                <div class="flex space-x-4 items-center">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-teal-600">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold text-white bg-teal-600 rounded-full hover:bg-teal-700 transition shadow-lg shadow-teal-600/30">Daftar</a>
                    @endguest

                    @auth
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-500 uppercase">{{ Auth::user()->role }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="p-2 text-red-400 hover:bg-red-50 rounded-full transition" title="Keluar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
        <!-- SweetAlert Trigger -->
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}",
                    timer: 2000, showConfirmButton: false, confirmButtonColor: '#0D9488'
                });
            </script>
        @endif
        
        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto py-6 text-center">
        <p class="text-xs text-gray-400">© 2025 SIPADI. Sistem Posyandu Digital Indonesia.</p>
    </footer>
</body>
</html>