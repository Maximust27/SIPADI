@extends('layout.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Register Balita Digital</h1>
            <p class="mt-1 text-sm text-gray-500">Rekapitulasi data dari Database.</p>
        </div>
        <button onclick="alert('Fitur Export Excel bisa menggunakan Laravel Excel')" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <span>📥 Download Excel</span>
        </button>
    </div>

    <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Input</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Anak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">L/P</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">BB / TB</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Gizi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($records as $child)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $child->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $child->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $child->age_months }} bln
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $child->gender }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $child->weight }}kg / {{ $child->height }}cm
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge {{ $child->status_gizi == 'Stunting' ? 'status-stunting' : 'status-normal' }}">
                                {{ $child->status_gizi }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            Belum ada data. <a href="{{ route('input') }}" class="text-teal-600 font-bold">Input Baru</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection