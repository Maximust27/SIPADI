@extends('layout.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-end mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Kader Posyandu</h1>
            <p class="text-gray-500">Ringkasan data kesehatan desa terkini.</p>
        </div>
        <span class="px-3 py-1 bg-teal-100 text-teal-700 rounded-full text-xs font-bold">Petugas: {{ Auth::user()->name }}</span>
    </div>
    
    <!-- BAGIAN 1: STATISTIK (KODE LAMA) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Total Data Masuk</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ $total }}</h3>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kasus Stunting</p>
                <h3 class="text-2xl font-bold text-red-600">{{ $stunting }}</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-green-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-gray-500">Anak Sehat (Normal)</p>
                <h3 class="text-2xl font-bold text-green-600">{{ $normal }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- PANEL TAMBAHAN: PERHATIAN KHUSUS (STUNTING) -->
<div class="bg-red-50 border border-red-100 rounded-2xl p-6 mb-8 shadow-sm">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-lg text-red-800 flex items-center gap-2">
            <span class="bg-red-200 p-1.5 rounded-lg">🚨</span>
            Daftar Prioritas Penanganan (Stunting)
        </h3>
        <button class="text-xs bg-white border border-red-200 text-red-600 px-3 py-1 rounded-lg font-bold hover:bg-red-100 transition">
            Download Data
        </button>
    </div>

    @if($stuntingList->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($stuntingList as $child)
            <div class="bg-white p-4 rounded-xl border-l-4 border-red-500 shadow-sm flex flex-col justify-between">
                <div>
                    <h4 class="font-bold text-gray-800">{{ $child->child_name }}</h4>
                    <p class="text-xs text-gray-500">Ortu: {{ $child->parent->name ?? '-' }}</p>
                    <div class="mt-2 text-xs font-mono text-gray-600 bg-gray-50 p-1 rounded inline-block">
                        Umur: {{ $child->age_months }} Bln | TB: {{ $child->height }}cm
                    </div>
                </div>
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <a href="#" class="text-xs font-bold text-red-600 hover:underline flex items-center gap-1">
                        <span>🏥</span> Rujuk ke Puskesmas
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">Tidak ada data stunting baru. Alhamdulillah!</p>
    @endif
</div>

<!-- BAGIAN 2: TABEL DATA MASUK (KODE LAMA) -->
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-10">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
        <h3 class="font-bold text-gray-800">Data Masuk Terbaru (Real-time)</h3>
        <button onclick="window.print()" class="text-sm text-teal-600 hover:underline">Cetak Laporan</button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase font-medium">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Orang Tua</th>
                    <th class="px-6 py-3">Nama Anak</th>
                    <th class="px-6 py-3">Umur</th>
                    <th class="px-6 py-3">Detail Fisik</th>
                    <th class="px-6 py-3">Status Gizi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $rec)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-500">{{ $rec->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $rec->parent->name ?? 'Umum' }}</td>
                    <td class="px-6 py-4 text-gray-800">{{ $rec->child_name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $rec->age_months }} bln</td>
                    <td class="px-6 py-4 text-gray-500">
                        BB:{{ $rec->weight }}kg / TB:{{ $rec->height }}cm
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $rec->status_gizi == 'Stunting' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                            {{ $rec->status_gizi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-400">Belum ada data masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 bg-gray-50 border-t border-gray-100">
        {{ $records->links() }}
    </div>
</div>

<!-- ========================================== -->
<!-- BAGIAN 3: PANEL KONSULTASI (FITUR BARU) -->
<!-- ========================================== -->

{{-- Kita panggil data konsultasi yang pending langsung di sini --}}
@php
    $consultations = \App\Models\Consultation::with('user')->where('status', 'pending')->latest()->get();
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- KOLOM KIRI: DAFTAR PERTANYAAN MASUK -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-orange-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-xl text-gray-800 flex items-center gap-2">
                <span class="bg-orange-100 p-2 rounded-lg text-orange-600">💬</span>
                Konsultasi Masuk
            </h3>
            @if($consultations->count() > 0)
                <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                    {{ $consultations->count() }} Pesan Baru
                </span>
            @else
                <span class="bg-gray-200 text-gray-500 text-xs font-bold px-3 py-1 rounded-full">
                    0 Pesan
                </span>
            @endif
        </div>

        <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
            @forelse($consultations as $chat)
            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md transition bg-gray-50">
                <div class="flex justify-between items-start mb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center text-teal-700 font-bold text-xs">
                            {{ substr($chat->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900 text-sm">{{ $chat->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $chat->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="text-xs bg-white border border-gray-200 px-2 py-1 rounded text-gray-500">
                        {{ $chat->subject }}
                    </span>
                </div>
                
                <div class="bg-white p-3 rounded-lg border border-gray-200 mb-3">
                    <p class="text-gray-700 text-sm italic">"{{ $chat->question }}"</p>
                </div>

                <!-- Form Balas Cepat -->
                <form action="{{ route('kader.reply', $chat->id) }}" method="POST">
                    @csrf
                    <label class="text-xs font-bold text-gray-500 uppercase">Balasan Anda:</label>
                    <textarea name="answer" rows="2" class="w-full border-gray-300 rounded-lg text-sm focus:ring-teal-500 focus:border-teal-500 mt-1" placeholder="Tulis saran/jawaban..." required></textarea>
                    <div class="mt-2 flex justify-end">
                        <button class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            Kirim Balasan
                        </button>
                    </div>
                </form>
            </div>
            @empty
            <div class="text-center py-12">
                <div class="flex justify-center mb-3">
                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <p class="text-gray-400 text-sm">Tidak ada pertanyaan baru saat ini.</p>
                <p class="text-gray-400 text-xs">Kerja bagus, Bu Kader! 👍</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- KOLOM KANAN: PANDUAN JAWABAN CEPAT -->
    <div class="bg-teal-800 p-6 rounded-2xl shadow-lg text-white h-fit sticky top-24">
        <h3 class="font-bold text-xl mb-6 flex items-center gap-2">
            <span>📚</span> Panduan Jawaban Cepat
        </h3>
        <div class="space-y-4 text-sm text-teal-50">
            
            <div class="p-4 bg-teal-700/50 rounded-xl border border-teal-600">
                <p class="font-bold text-white mb-1 flex items-center gap-2">
                    <span class="w-2 h-2 bg-red-400 rounded-full"></span> Jika Anak Demam > 38°C
                </p>
                <p class="leading-relaxed opacity-90">"Saran: Berikan kompres hangat di lipatan ketiak, berikan banyak minum/ASI, dan segera bawa ke Puskesmas jika demam tidak turun dalam 2 hari."</p>
            </div>

            <div class="p-4 bg-teal-700/50 rounded-xl border border-teal-600">
                <p class="font-bold text-white mb-1 flex items-center gap-2">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full"></span> Jika Berat Badan Turun
                </p>
                <p class="leading-relaxed opacity-90">"Saran: Tambahkan porsi protein hewani (telur/ikan) pada setiap makan. Kami akan memantau lagi 2 minggu ke depan. Pastikan anak tidak sedang sakit gigi/sariawan."</p>
            </div>

            <div class="p-4 bg-teal-700/50 rounded-xl border border-teal-600">
                <p class="font-bold text-white mb-1 flex items-center gap-2">
                    <span class="w-2 h-2 bg-orange-400 rounded-full"></span> Jika Indikasi Stunting
                </p>
                <p class="leading-relaxed opacity-90">"Saran: Harap datang ke Posyandu bulan depan untuk pengukuran ulang dan pengambilan Paket Makanan Tambahan (PMT). Perbaiki sanitasi lingkungan rumah."</p>
            </div>

            <div class="p-4 bg-teal-700/50 rounded-xl border border-teal-600">
                <p class="font-bold text-white mb-1 flex items-center gap-2">
                    <span class="w-2 h-2 bg-blue-400 rounded-full"></span> Pertanyaan Jadwal Imunisasi
                </p>
                <p class="leading-relaxed opacity-90">"Jadwal Posyandu bulan ini adalah tanggal 10. Silakan bawa buku KIA (Pink). Tersedia imunisasi Campak dan Polio."</p>
            </div>

        </div>
    </div>
</div>
@endsection