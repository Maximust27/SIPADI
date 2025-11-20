@extends('layout.app')

@section('content')
<div class="space-y-8">
    <div class="text-center sm:text-left border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-900">Kalkulator Gizi & Input Data</h1>
        <p class="mt-1 text-sm text-gray-500">Masukkan data pengukuran, server akan menghitung status gizi otomatis.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- FORM INPUT -->
        <div class="lg:col-span-1 bg-white p-6 rounded-xl card-shadow h-fit">
            <form action="{{ route('store') }}" method="POST">
                @csrf <!-- Token Keamanan Laravel -->
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Anak</label>
                        <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2" placeholder="Contoh: Budi">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tgl Lahir</label>
                            <!-- Tambahkan sedikit JS helper untuk hitung umur di frontend juga (opsional, agar interaktif) -->
                            <input type="date" name="birth_date" id="birthDate" required onchange="previewAge()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded text-sm text-gray-600">
                        Estimasi Umur: <span id="ageDisplay" class="font-bold text-teal-700">--</span> bulan
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                            <input type="number" step="0.1" name="weight" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                            <input type="number" step="0.1" name="height" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700 mt-4">
                        Hitung & Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- HASIL & CHART (Hanya muncul jika Session Result ada) -->
        <div class="lg:col-span-2 space-y-6">
            
            @if(session('result'))
                @php $res = session('result'); @endphp
                <!-- Result Card -->
                <div class="bg-white p-6 rounded-xl card-shadow border-t-4 {{ $res->status_gizi == 'Stunting' ? 'border-red-500' : 'border-green-500' }}">
                    <h3 class="text-lg font-bold text-gray-900">Hasil Analisis Gizi ({{ $res->name }})</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-lg bg-gray-50">
                            <span class="text-xs text-gray-500 uppercase tracking-wide">Indeks Massa Tubuh (IMT)</span>
                            <div class="text-2xl font-bold text-gray-800">{{ $res->bmi }}</div>
                        </div>
                        <div class="p-4 rounded-lg {{ $res->status_gizi == 'Stunting' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            <span class="text-xs uppercase tracking-wide opacity-75">Status Gizi (TB/U)</span>
                            <div class="text-2xl font-bold">{{ strtoupper($res->status_gizi) }}</div>
                            <div class="text-sm mt-1">
                                @if($res->status_gizi == 'Stunting')
                                    ⚠️ Tinggi di bawah standar usia. Perlu PMT.
                                @else
                                    ✅ Pertumbuhan Normal. Lanjutkan ASI/MPASI.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="bg-white p-6 rounded-xl card-shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Grafik Pertumbuhan (KMS Digital)</h3>
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Posisi Anak Ini</span>
                    </div>
                    <div class="chart-container">
                        <canvas id="kmsChart"></canvas>
                    </div>
                </div>

                <!-- Script Khusus Render Chart Hasil -->
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const ctx = document.getElementById('kmsChart').getContext('2d');
                        
                        // Generate Garis Median (Sama seperti JS sebelumnya, tapi statis)
                        const labels = Array.from({length: 60}, (_, i) => i); 
                        const medianData = labels.map(m => (m <= 12) ? 50 + (2.5 * m) : 80 + (0.8 * (m - 12)));
                        const stuntData = medianData.map(h => h * 0.92);

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Anak Ini ({{ $res->name }})',
                                        data: [{x: {{ $res->age_months }}, y: {{ $res->height }}}], // Data dari PHP
                                        borderColor: '#0D9488',
                                        backgroundColor: '#0D9488',
                                        pointRadius: 8,
                                        showLine: false
                                    },
                                    {
                                        label: 'Median WHO',
                                        data: medianData,
                                        borderColor: '#9CA3AF',
                                        borderDash: [5, 5],
                                        pointRadius: 0,
                                        fill: false
                                    },
                                    {
                                        label: 'Batas Stunting (-2SD)',
                                        data: stuntData,
                                        borderColor: '#FCA5A5',
                                        pointRadius: 0,
                                        fill: { target: 'origin', above: 'rgba(254, 226, 226, 0.5)' }
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    x: { title: { display: true, text: 'Umur (Bulan)' }, type: 'linear', min: 0, max: 60 },
                                    y: { title: { display: true, text: 'Tinggi (cm)' } }
                                }
                            }
                        });
                    });
                </script>
            @else
                <div class="flex items-center justify-center h-full bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-10">
                    <div class="text-center">
                        <p class="text-gray-500">Silakan isi form di samping untuk melihat hasil analisis dan grafik pertumbuhan.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // JS Helper kecil untuk preview umur saat user memilih tanggal
    function previewAge() {
        const dob = new Date(document.getElementById('birthDate').value);
        const today = new Date();
        let months = (today.getFullYear() - dob.getFullYear()) * 12;
        months -= dob.getMonth();
        months += today.getMonth();
        if (months < 0) months = 0;
        document.getElementById('ageDisplay').innerText = months;
    }
</script>
@endsection