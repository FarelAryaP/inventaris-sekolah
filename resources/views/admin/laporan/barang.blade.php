@extends('layouts.admin')

@section('title', 'Laporan Barang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.laporan.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Barang</h1>
            <p class="text-gray-600">Statistik dan analisis barang inventaris</p>
        </div>
        <button onclick="window.print()" class="btn-secondary btn-sm no-print">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="card">
            <p class="text-sm text-gray-600">Total Barang</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_barang'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Stok Rendah</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['stok_rendah'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Tidak Pernah Dipinjam</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['tidak_dipinjam'] }}</p>
        </div>
    </div>

    <!-- Barang Paling Populer -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Top 10 Barang Paling Sering Dipinjam</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="table-header">Ranking</th>
                        <th class="table-header">Nama Barang</th>
                        <th class="table-header">Total Pengajuan</th>
                        <th class="table-header">Total Dipinjam</th>
                        <th class="table-header">Stok Tersedia</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($barang_populer as $index => $barang)
                    <tr>
                        <td class="table-cell">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-800' : ($index == 1 ? 'bg-gray-200 text-gray-800' : ($index == 2 ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-600')) }} font-bold">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="table-cell font-medium">{{ $barang->nama_barang }}</td>
                        <td class="table-cell">{{ $barang->total_pengajuan }}</td>
                        <td class="table-cell">{{ $barang->jumlah_dipinjam }}</td>
                        <td class="table-cell">{{ $barang->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Barang Stok Rendah -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Barang dengan Stok Rendah (< 5)</h2>
        @if($barang_stok_rendah->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="table-header">Nama Barang</th>
                        <th class="table-header">Stok</th>
                        <th class="table-header">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($barang_stok_rendah as $barang)
                    <tr>
                        <td class="table-cell font-medium">{{ $barang->nama_barang }}</td>
                        <td class="table-cell">
                            <span class="px-3 py-1 rounded-full {{ $barang->jumlah == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }} font-semibold">
                                {{ $barang->jumlah }}
                            </span>
                        </td>
                        <td class="table-cell text-gray-600">{{ $barang->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 py-4">Semua barang memiliki stok yang aman</p>
        @endif
    </div>

    <!-- Barang Tidak Dipinjam -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Barang Tidak Pernah Dipinjam</h2>
        @if($barang_tidak_dipinjam->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="table-header">Nama Barang</th>
                        <th class="table-header">Stok</th>
                        <th class="table-header">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($barang_tidak_dipinjam as $barang)
                    <tr>
                        <td class="table-cell">{{ $barang->nama_barang }}</td>
                        <td class="table-cell">{{ $barang->jumlah }}</td>
                        <td class="table-cell text-gray-600">{{ $barang->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 py-4">Semua barang pernah dipinjam</p>
        @endif
    </div>
</div>

<style>
@media print {
    nav, .no-print { display: none !important; }
}
</style>
@endsection