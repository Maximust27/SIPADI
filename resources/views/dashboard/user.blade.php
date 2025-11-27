@extends('layout.app')

@section('content')

{{-- LOGIKA PHP SERVER SIDE --}}
@php
    // Urutkan data agar grafik terbaca dari kiri (umur kecil) ke kanan
    $sortedRecords = $records->sortBy('age_months')->values();
    
    // Ambil chat terakhir
    $recentChats = \App\Models\Consultation::where('user_id', Auth::id())->latest()->take(2)->get();
@endphp

<div class="space-y-8">
    
    <!-- HEADER DENGAN ANIMASI -->
    <div class="animate-enter">
        <div class="relative bg-gradient-to-r from-teal-600 to-emerald-500 rounded-3xl p-8 text-white shadow-xl shadow-teal-500/20 overflow-hidden group">
            <!-- Ornamen Background -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition duration-700"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-black/10 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-teal-50 mt-2 text-lg font-medium opacity-90">Pantau tumbuh kembang si kecil dengan Standar WHO.</p>
                </div>
                
                <!-- Tombol Tanya Kader -->
                <a href="{{ route('user.consultation') }}" class="group/btn bg-white text-teal-700 px-6 py-3 rounded-2xl font-bold shadow-lg hover:shadow-xl hover:bg-teal-50 transition-all transform hover:-translate-y-1 flex items-center gap-3">
                    <span class="text-xl">💬</span>
                    <span>Tanya Kader</span>
                    <svg class="w-5 h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- ========================== -->
        <!-- KOLOM KIRI (INPUT & CHAT) -->
        <!-- ========================== -->
        <div class="lg:col-span-1 space-y-8 animate-enter delay-100">
            
            <!-- 1. FORM INPUT MODERN -->
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 hover-scale relative overflow-hidden">
                <div class="absolute top-0 left-0 w-1.5 h-full bg-teal-500"></div>
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 shadow-sm">📝</div>
                    Input Pengukuran
                </h2>
                
                <form action="{{ route('user.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Nama Anak</label>
                        <input type="text" name="child_name" class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 transition font-medium" placeholder="Nama Lengkap" required>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Gender</label>
                            <div class="relative">
                                <select name="gender" id="inputGender" class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 appearance-none font-medium cursor-pointer">
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">▼</div>
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Tgl Lahir</label>
                            <input type="date" name="birth_date" id="birthDate" onchange="calculateAge()" class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 font-medium" required>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between bg-teal-50/50 p-3 rounded-xl border border-teal-100">
                        <span class="text-xs text-teal-600 font-semibold">Estimasi Umur:</span>
                        <span id="agePreview" class="font-bold text-teal-800 text-lg">-- <span class="text-xs font-normal">Bln</span></span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Berat (kg)</label>
                            <input type="number" step="0.1" name="weight" class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 font-bold text-gray-800" placeholder="0.0" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Tinggi (cm)</label>
                            <input type="number" step="0.1" name="height" class="w-full px-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-teal-500 font-bold text-gray-800" placeholder="0.0" required>
                        </div>
                    </div>

                    <button class="w-full bg-gray-900 hover:bg-black text-white font-bold py-3.5 rounded-xl shadow-lg shadow-gray-900/20 transition-all transform hover:-translate-y-1 flex justify-center items-center gap-2">
                        <span>Simpan Data</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            </div>

            <div class="bg-orange-50 p-6 rounded-3xl border border-orange-100 hover-scale relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-orange-100 rounded-full -mr-10 -mt-10 blur-xl"></div>

                <div class="flex items-center justify-between mb-6 relative z-10">
                    <h2 class="text-lg font-bold text-orange-900 flex items-center gap-2">
                        <span class="bg-white p-1.5 rounded-lg shadow-sm text-orange-500">💬</span>
                        Chat Kader
                    </h2>
                    <a href="{{ route('user.consultation') }}" class="text-xs font-bold text-orange-600 hover:underline">Lihat Semua</a>
                </div>

                <form action="{{ route('user.consultation.store') }}" method="POST" class="space-y-3 relative z-10">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Topik Masalah</label>
                        <div class="relative">
                            <select name="subject" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 appearance-none cursor-pointer font-medium">
                                <option>Demam / Sakit Ringan</option>
                                <option>Berat Badan Turun</option>
                                <option>Masalah MPASI / Menyusui</option>
                                <option>Jadwal Imunisasi</option>
                                <option>Tumbuh Kembang Anak</option>
                                <option>Lainnya</option>
                            </select>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-gray-400">▼</div>
                        </div>
                    </div>

                    <textarea name="question" rows="2" class="w-full px-4 py-3 bg-white border-orange-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none shadow-sm placeholder-gray-400" placeholder="Tulis keluhan lengkap di sini..." required></textarea>

                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 rounded-xl shadow-md transition flex justify-center items-center gap-2">
                        <span>Kirim Pesan</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>

                <!-- Mini History -->
                <div class="mt-6 pt-4 border-t border-orange-200/50 relative z-10">
                    <p class="text-[10px] font-bold text-orange-400 uppercase tracking-wider mb-3">Riwayat Terakhir</p>
                    <div class="space-y-3">
                        @forelse($recentChats as $chat)
                            <div class="bg-white/80 backdrop-blur-sm p-3 rounded-xl border border-orange-100 shadow-sm">
                                <div class="flex justify-between text-gray-400 text-[10px] mb-1">
                                    <!-- Menampilkan Subjek yang diketik user -->
                                    <span class="font-bold text-orange-600">{{ Str::limit($chat->subject, 20) }}</span>

                                    @if($chat->status == 'answered')
                                        <span class="text-green-600 font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Dijawab
                                        </span>
                                    @else
                                        <span class="text-orange-400 font-bold">Pending</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-700 line-clamp-1 italic">"{{ $chat->question }}"</p>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic text-center py-2">Belum ada chat.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================== -->
        <!-- KOLOM KANAN (GRAFIK & LIST) -->
        <!-- ========================== -->
        <div class="lg:col-span-2 space-y-8 animate-enter delay-200">
            
            <!-- 3. GRAFIK WHO -->
            <div class="bg-white p-8 rounded-3xl shadow-lg shadow-gray-100/50 border border-gray-100 relative">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="bg-blue-50 text-blue-600 p-2 rounded-xl">📈</span>
                            Grafik Pertumbuhan
                        </h2>
                        <p class="text-sm text-gray-400 mt-1 ml-1">Membandingkan dengan Standar WHO.</p>
                    </div>
                    
                    <!-- Filter Gender -->
                    <div class="bg-gray-50 p-1 rounded-xl border border-gray-200">
                        <select id="chartFilter" onchange="updateChartGender()" class="bg-transparent text-sm font-bold text-gray-600 py-1 px-2 outline-none cursor-pointer">
                            <option value="L">👦 Standar Laki-laki</option>
                            <option value="P">👧 Standar Perempuan</option>
                        </select>
                    </div>
                </div>
                
                <!-- Canvas Chart -->
                <div class="relative h-[380px] w-full">
                    <canvas id="growthChart"></canvas>
                </div>
                
                <!-- Legend Kustom -->
                <div class="mt-6 flex flex-wrap justify-center gap-6 text-xs font-bold text-gray-500">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-teal-500 shadow-sm"></span> Anak Anda
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-0.5 bg-gray-400 border-t border-dashed border-gray-400"></span> Median (Normal)
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-50 border border-red-500"></span> Area Stunting (-2SD)
                    </div>
                </div>
            </div>

            <!-- 4. LIST RIWAYAT -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-2">
                    <h2 class="text-lg font-bold text-gray-800">Riwayat Pemeriksaan</h2>
                    <span class="text-xs font-bold bg-gray-100 text-gray-500 px-3 py-1 rounded-full">{{ $records->count() }} Data</span>
                </div>

                @if($records->count() > 0)
                    <div class="grid gap-4">
                        @foreach($records as $rec)
                        <div class="group bg-white p-5 rounded-2xl border border-gray-100 hover:border-teal-200 hover:shadow-lg transition-all duration-300 flex justify-between items-center relative overflow-hidden">
                            <!-- Status Bar -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $rec->status_gizi == 'Stunting' ? 'bg-red-500' : 'bg-emerald-500' }}"></div>
                            
                            <div class="pl-4">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="font-bold text-gray-900 text-base">{{ $rec->child_name }}</div>
                                    @if($loop->first)
                                        <span class="bg-teal-50 text-teal-600 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wide border border-teal-100">Baru</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3 text-xs text-gray-500 font-medium">
                                    <span class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded">
                                        📅 {{ $rec->created_at->format('d M Y') }}
                                    </span>
                                    <span>👶 {{ $rec->age_months }} Bulan</span>
                                </div>
                            </div>
                            
                            <div class="text-right">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase tracking-wide shadow-sm
                                    {{ $rec->status_gizi == 'Stunting' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                    {{ $rec->status_gizi }}
                                </span>
                                <div class="text-xs font-mono text-gray-400 font-semibold mt-2">
                                    {{ $rec->height }}cm
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200 hover:border-teal-300 transition-colors group">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <span class="text-3xl grayscale group-hover:grayscale-0 transition">📊</span>
                        </div>
                        <p class="text-gray-500 font-medium text-sm">Belum ada data pengukuran.</p>
                        <p class="text-gray-400 text-xs mt-1">Yuk, mulai isi data anak Anda!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // --- 1. DATA PHP KE JS (Safe JSON Encode) ---
    const records = {!! json_encode($sortedRecords) !!};
    
    // Mapping Data Anak
    const childDataPoints = records.map(rec => ({
        x: rec.age_months,
        y: rec.height,
        name: rec.child_name
    }));

    // --- 2. DATA WHO & RUMUS ---
    const labels = Array.from({length: 61}, (_, i) => i); // 0-60 Bulan
    
    // Rumus Aproksimasi Median (Normal)
    const medianData = labels.map(m => (m <= 12) ? 50 + (2.5 * m) : 80 + (0.8 * (m - 12)));
    
    // Rumus Batas Bawah Stunting (-2SD)
    const stuntingLimitData = medianData.map(h => h * 0.92);

    let chartInstance = null;

    // --- 3. FUNGSI RENDER CHART ---
    function initChart(genderType) {
        const ctx = document.getElementById('growthChart').getContext('2d');
        
        // Efek Gradient Merah untuk Area Stunting
        let gradientStunting = ctx.createLinearGradient(0, 0, 0, 400);
        gradientStunting.addColorStop(0, 'rgba(239, 68, 68, 0.2)'); 
        gradientStunting.addColorStop(1, 'rgba(239, 68, 68, 0.05)');

        if(chartInstance) chartInstance.destroy();

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Tinggi Anak',
                        data: childDataPoints,
                        borderColor: '#0D9488', // Teal Solid
                        backgroundColor: '#0D9488',
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0D9488',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        borderWidth: 3,
                        tension: 0.3, // Sedikit smooth
                        showLine: true, // Hubungkan garis anak
                        order: 1
                    },
                    {
                        label: 'Median (Normal)',
                        data: medianData,
                        borderColor: '#9CA3AF', // Abu-abu
                        borderWidth: 2,
                        borderDash: [5, 5], // Garis Putus-putus
                        pointRadius: 0,
                        fill: false,
                        tension: 0.4,
                        order: 2
                    },
                    {
                        label: 'Batas Stunting (-2SD)',
                        data: stuntingLimitData,
                        borderColor: '#EF4444', // Merah
                        borderWidth: 2,
                        pointRadius: 0,
                        fill: {
                            target: 'origin',
                            above: gradientStunting // Area Merah di bawah
                        },
                        tension: 0.4,
                        order: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000, // Animasi masuk lambat ala React
                    easing: 'easeOutQuart'
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    x: { 
                        title: { display: true, text: 'Umur (Bulan)', font: {family: "'Plus Jakarta Sans', sans-serif"} },
                        grid: { display: false }
                    },
                    y: { 
                        title: { display: true, text: 'Tinggi Badan (cm)', font: {family: "'Plus Jakarta Sans', sans-serif"} },
                        min: 40,
                        grid: { borderDash: [4, 4], color: '#F3F4F6' }
                    }
                },
                plugins: {
                    legend: { display: false }, // Kita pakai legend custom di HTML
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#111827',
                        bodyColor: '#374151',
                        borderColor: '#E5E7EB',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 12,
                        titleFont: { family: "'Plus Jakarta Sans', sans-serif", size: 13 },
                        bodyFont: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw.y.toFixed(1) + ' cm';
                            }
                        }
                    }
                }
            }
        });
    }

    function updateChartGender() {
        const gender = document.getElementById('chartFilter').value;
        initChart(gender);
    }

    function calculateAge() {
        const dobInput = document.getElementById('birthDate').value;
        if(!dobInput) return;
        const dob = new Date(dobInput);
        const today = new Date();
        let months = (today.getFullYear() - dob.getFullYear()) * 12;
        months -= dob.getMonth();
        months += today.getMonth();
        if (months < 0) months = 0;
        document.getElementById('agePreview').innerText = months;
    }

    document.addEventListener('DOMContentLoaded', function() {
        initChart('L');
    });
</script>
@endsection