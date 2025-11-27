@extends('layout.app')

@section('content')

<!-- 1. HERO SECTION -->
<section class="relative pt-10 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
    
    <!-- Animated Background Blobs (Hiasan Latar Belakang Bergerak) -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-teal-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-20 right-10 w-72 h-72 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/2 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            
            <!-- Text Content (Kiri) -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <div class="animate-enter">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-50 border border-teal-100 text-teal-700 text-xs font-bold uppercase tracking-wide mb-6 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        Sistem Posyandu Digital 4.0
                    </span>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
                        Pantau Tumbuh <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-emerald-500">Kembang Anak</span>
                        <br> Lebih Akurat.
                    </h1>
                    
                    <p class="text-lg text-gray-500 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium">
                        Tinggalkan pencatatan manual. SIPADI membantu kader dan orang tua memantau status gizi balita dengan standar WHO secara real-time dan terintegrasi.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-enter delay-100">
                    <a href="{{ route('dashboard') }}" class="group relative px-8 py-4 bg-teal-600 text-white font-bold rounded-2xl shadow-xl shadow-teal-500/30 hover:bg-teal-700 transition-all transform hover:-translate-y-1 overflow-hidden">
                        <span class="relative z-10 flex items-center gap-2">
                            Masuk Dashboard
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </span>
                        <!-- Efek Kilau -->
                        <div class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    </a>
                    
                    <a href="#fitur" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-2xl shadow-md border border-gray-100 hover:bg-gray-50 transition-all transform hover:-translate-y-1">
                        Pelajari Fitur
                    </a>
                </div>
            </div>
            
            <!-- Hero Image / Illustration (Kanan) -->
            <div class="lg:w-1/2 relative animate-enter delay-200">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white/50 backdrop-blur-xl transform rotate-3 hover:rotate-0 transition duration-700 ease-out">
                    <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?q=80&w=1000&auto=format&fit=crop" 
                         alt="Ibu dan Anak Sehat" 
                         class="w-full h-auto object-cover transform hover:scale-105 transition duration-700">
                    
                    <!-- Floating Card 1 -->
                    <div class="absolute top-6 left-6 bg-white/90 backdrop-blur p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-bounce" style="animation-duration: 3s;">
                        <div class="bg-green-100 p-2 rounded-full text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Status Gizi</p>
                            <p class="font-bold text-gray-900">Normal (Sehat)</p>
                        </div>
                    </div>

                    <!-- Floating Card 2 -->
                    <div class="absolute bottom-6 right-6 bg-white/90 backdrop-blur p-4 rounded-2xl shadow-lg flex items-center gap-3 animate-bounce" style="animation-duration: 4s;">
                        <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-semibold uppercase">Grafik</p>
                            <p class="font-bold text-gray-900">Sesuai WHO</p>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Dots -->
                <div class="absolute -bottom-10 -right-10 grid grid-cols-6 gap-2 z-[-1]">
                    @for($i=0; $i<24; $i++)
                        <div class="w-2 h-2 bg-teal-200 rounded-full"></div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. FEATURES SECTION -->
<section id="fitur" class="py-20 bg-white relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16 animate-enter delay-300">
            <h2 class="text-base text-teal-600 font-bold tracking-wide uppercase mb-2">Fitur Unggulan</h2>
            <h3 class="text-4xl font-extrabold text-gray-900 mb-4">Teknologi untuk Generasi Emas</h3>
            <p class="text-gray-500 text-lg">Sistem kami dirancang khusus untuk memudahkan kader dan memberikan ketenangan bagi orang tua.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Feature 1 -->
            <div class="group p-8 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-2xl hover:shadow-teal-500/10 transition duration-300 hover-scale relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-teal-500 w-24 h-24 rounded-bl-[100px] opacity-0 group-hover:opacity-10 transition duration-300"></div>
                
                <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center text-teal-600 mb-6 group-hover:scale-110 transition duration-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Kalkulator Gizi Otomatis</h4>
                <p class="text-gray-500 leading-relaxed">
                    Sistem menghitung Z-Score secara otomatis berdasarkan standar WHO. Tidak perlu lagi hitung manual yang rawan salah.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="group p-8 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-2xl hover:shadow-blue-500/10 transition duration-300 hover-scale relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-blue-500 w-24 h-24 rounded-bl-[100px] opacity-0 group-hover:opacity-10 transition duration-300"></div>

                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition duration-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Visualisasi KMS Digital</h4>
                <p class="text-gray-500 leading-relaxed">
                    Grafik pertumbuhan interaktif yang mudah dipahami orang tua. Lihat tren kenaikan berat & tinggi badan anak dengan jelas.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="group p-8 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-2xl hover:shadow-orange-500/10 transition duration-300 hover-scale relative overflow-hidden">
                <div class="absolute top-0 right-0 bg-orange-500 w-24 h-24 rounded-bl-[100px] opacity-0 group-hover:opacity-10 transition duration-300"></div>

                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-6 group-hover:scale-110 transition duration-300 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Konsultasi Kader</h4>
                <p class="text-gray-500 leading-relaxed">
                    Orang tua bisa bertanya langsung kepada kader via fitur chat jika ada keluhan kesehatan pada anak.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- 3. CALL TO ACTION (CTA) -->
<section class="py-20 px-6">
    <div class="container mx-auto">
        <div class="bg-gradient-to-r from-teal-800 to-emerald-800 rounded-[3rem] p-10 lg:p-20 text-center relative overflow-hidden shadow-2xl">
            
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 30px 30px;"></div>
            <div class="absolute top-0 left-0 w-64 h-64 bg-teal-500 rounded-full mix-blend-overlay filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute bottom-0 right-0 w-64 h-64 bg-emerald-500 rounded-full mix-blend-overlay filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-6 tracking-tight">Siap Wujudkan Desa Bebas Stunting?</h2>
                <p class="text-teal-100 text-xl mb-10 font-medium">Bergabunglah dengan ribuan kader dan orang tua lainnya untuk masa depan anak Indonesia yang lebih cerah.</p>
                
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="px-10 py-5 bg-white text-teal-900 font-bold rounded-2xl shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1 text-lg">
                        Mulai Sekarang
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="px-10 py-5 bg-teal-700/50 backdrop-blur border border-teal-500 text-white font-bold rounded-2xl hover:bg-teal-700 transition transform hover:-translate-y-1 text-lg">
                        Daftar Akun Baru
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Animasi Kilau pada Tombol */
    @keyframes shimmer {
        100% { left: 100%; }
    }
    
    /* Animasi Blob Background */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection