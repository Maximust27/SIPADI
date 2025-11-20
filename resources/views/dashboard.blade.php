@extends('layout.app')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div class="text-center sm:text-left">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pemantauan Stunting</h1>
        <p class="mt-1 text-sm text-gray-500">Data Real-time Posyandu Mawar Desa Sejahtera</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl p-6 card-shadow border-l-4 border-teal-500">
            <div class="text-sm font-medium text-gray-500">Total Anak Diukur</div>
            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $total }}</div>
            <div class="text-xs text-gray-400 mt-1">Bulan Ini</div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow border-l-4 border-red-500">
            <div class="text-sm font-medium text-gray-500">Terindikasi Stunting</div>
            <div class="mt-2 text-3xl font-bold text-red-600">{{ $stunted }}</div>
            <div class="text-xs text-red-400 mt-1">Perlu Intervensi Segera</div>
        </div>
        <div class="bg-white rounded-xl p-6 card-shadow border-l-4 border-green-500">
            <div class="text-sm font-medium text-gray-500">Gizi Baik</div>
            <div class="mt-2 text-3xl font-bold text-green-600">{{ $normal }}</div>
            <div class="text-xs text-gray-400 mt-1">Pertahankan</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-xl card-shadow">
            <h3 class="text-lg font-semibold mb-4">Proporsi Status Gizi</h3>
            <div class="chart-container">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
        <div class="bg-teal-50 p-6 rounded-xl border border-teal-100">
            <h3 class="text-lg font-semibold text-teal-900 mb-2">Mengapa Digitalisasi?</h3>
            <p class="text-sm text-teal-800 mb-4">
                Aplikasi ini menghilangkan kesalahan matematika kader.
            </p>
            <ul class="space-y-2 text-sm text-teal-700">
                <li class="flex items-start"><span class="mr-2">✓</span><span><strong>Akurasi:</strong> Server menghitung Z-Score otomatis.</span></li>
                <li class="flex items-start"><span class="mr-2">✓</span><span><strong>Aman:</strong> Data tersimpan di Database MySQL.</span></li>
            </ul>
            <a href="{{ route('input') }}" class="mt-6 inline-block w-full bg-teal-600 text-white py-2 px-4 rounded-lg hover:bg-teal-700 text-center font-medium">
                Mulai Input Data Anak
            </a>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Normal', 'Stunting'],
            datasets: [{
                data: [{{ $normal }}, {{ $stunted }}],
                backgroundColor: ['#10B981', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection