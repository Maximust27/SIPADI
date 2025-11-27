@extends('layout.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    
    <!-- Card Register -->
    <div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-2xl shadow-teal-500/10 border border-gray-100 animate-enter">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-teal-50 text-teal-600 mb-4 shadow-sm transform hover:scale-110 transition duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Buat Akun Baru</h2>
            <p class="text-sm text-gray-500 mt-1 font-medium">Bergabunglah untuk memantau tumbuh kembang anak.</p>
        </div>

        <!-- Alert Error -->
        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 animate-pulse">
                <ul class="list-disc list-inside text-sm text-red-600 font-semibold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <input type="text" name="name" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-gray-50 focus:bg-white font-medium" placeholder="Contoh: Budi Santoso" required>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </div>
                    <input type="email" name="email" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-gray-50 focus:bg-white font-medium" placeholder="nama@email.com" required>
                </div>
            </div>
            
            <!-- Password -->
            <div x-data="{ show: false }">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input :type="show ? 'text' : 'password'" name="password" class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition bg-gray-50 focus:bg-white font-medium" placeholder="Minimal 6 karakter" required>
                    
                    <!-- Toggle Show Password -->
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer focus:outline-none">
                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 011.591-2.786l3.322 5.611zm6.173-1.535l-3.867-6.535m3.867 6.535A9.953 9.953 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7-1.053 0-2.062.168-3.022.479m5.96 11.922l-8.98-15.166"></path></svg>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-1 ml-1">*Gunakan kombinasi huruf dan angka.</p>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl transition duration-200 shadow-lg shadow-teal-600/30 transform hover:-translate-y-0.5 flex justify-center items-center gap-2">
                <span>Daftar Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-100 text-center">
            <p class="text-sm text-gray-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-teal-600 hover:text-teal-700 font-bold hover:underline transition">Login di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection