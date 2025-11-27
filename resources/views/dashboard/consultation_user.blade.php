@extends('layout.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-enter">
    
    <!-- Header & Navigasi Kembali -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Ruang Konsultasi</h1>
            <p class="text-gray-500 mt-1">Tanyakan masalah kesehatan anak langsung kepada Kader Posyandu.</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="group flex items-center gap-2 text-sm font-bold text-teal-600 bg-teal-50 px-4 py-2 rounded-xl hover:bg-teal-100 transition">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: FORMULIR BERTANYA -->
        <div class="md:col-span-1">
            <div class="bg-white p-6 rounded-3xl shadow-lg shadow-orange-500/5 border border-orange-100 sticky top-24">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">Buat Pertanyaan</h2>
                </div>

                <form action="{{ route('user.consultation.store') }}" method="POST" class="space-y-4">
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

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Detail Pertanyaan</label>
                        <textarea name="question" rows="5" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-xl p-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none placeholder-gray-400" placeholder="Ceritakan kondisi anak, gejala, dan sudah berapa lama..." required></textarea>
                    </div>

                    <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-xl shadow-md shadow-orange-500/20 transition transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        <span>Kirim ke Kader</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </form>
                
                <div class="mt-4 p-3 bg-blue-50 rounded-xl border border-blue-100">
                    <p class="text-xs text-blue-700 leading-relaxed">
                        <strong>Info:</strong> Untuk keadaan darurat (kejang, sesak napas, tidak sadar), segera bawa ke IGD/Puskesmas terdekat.
                    </p>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: RIWAYAT CHAT -->
        <div class="md:col-span-2 space-y-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <span>📋</span> Riwayat Konsultasi
            </h2>

            @forelse($chats as $chat)
                <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-md transition duration-300 animate-enter">
                    
                    <!-- Bagian Pertanyaan (Header Card) -->
                    <div class="p-6 bg-white">
                        <div class="flex justify-between items-start mb-3">
                            <span class="bg-gray-100 text-gray-600 text-xs font-bold px-3 py-1 rounded-full border border-gray-200">
                                {{ $chat->subject }}
                            </span>
                            <span class="text-xs font-medium text-gray-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $chat->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-gray-800 font-medium leading-relaxed">"{{ $chat->question }}"</p>
                    </div>

                    <!-- Bagian Jawaban (Footer Card) -->
                    <div class="px-6 py-5 border-t border-gray-50 
                        {{ $chat->status == 'answered' ? 'bg-teal-50/50' : 'bg-gray-50' }}">
                        
                        @if($chat->status == 'answered')
                            <div class="flex gap-4">
                                <!-- Avatar Kader -->
                                <div class="flex-shrink-0 w-10 h-10 bg-teal-100 rounded-full flex items-center justify-center text-teal-600 shadow-sm border border-teal-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                </div>
                                
                                <div class="flex-grow">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="text-sm font-bold text-teal-800">{{ $chat->kader_name }}</p>
                                        <span class="text-[10px] px-1.5 py-0.5 bg-teal-200 text-teal-800 rounded font-bold">Kader</span>
                                    </div>
                                    <p class="text-gray-700 text-sm leading-relaxed">{{ $chat->answer }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Status Pending -->
                            <div class="flex items-center justify-center gap-2 text-gray-400 py-2">
                                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-gray-400"></div>
                                <span class="text-sm font-medium italic">Menunggu balasan petugas...</span>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-16 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl grayscale opacity-50">💬</span>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">Belum ada konsultasi</h3>
                    <p class="text-gray-500 text-sm mt-1">Gunakan formulir di sebelah kiri untuk mulai bertanya.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection