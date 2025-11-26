@extends('layouts.admin')

@section('title', 'Laporan Siswa')

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
            <h1 class="text-2xl font-bold text-gray-900">Laporan Siswa</h1>
            <p class="text-gray-600">Aktivitas peminjaman dan keterlambatan siswa</p>
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
            <p class="text-sm text-gray-600">Total Siswa</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_siswa'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Siswa Aktif</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['siswa_aktif'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Siswa Terlambat</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['siswa_terlambat'] }}</p>
        </div>
    </div>

    <!-- Top 10 Siswa Paling Aktif -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Top 10 Siswa Paling Aktif</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="table-header">Ranking</th>
                        <th class="table-header">NISN</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header">Kelas</th>
                        <th class="table-header">Total Pengajuan</th>
                        <th class="table-header">Disetujui</th>
                        <th class="table-header">Keterlambatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($siswa_aktif as $index => $siswa)
                    <tr>
                        <td class="table-cell">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-800' : ($index == 1 ? 'bg-gray-200 text-gray-800' : ($index == 2 ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-600')) }} font-bold">
                                {{ $index + 1 }}
                            </span>
                        </td>
                        <td class="table-cell">{{ $siswa->nisn }}</td>
                        <td class="table-cell font-medium">{{ $siswa->nama }}</td>
                        <td class="table-cell">{{ $siswa->kelas }}</td>
                        <td class="table-cell">{{ $siswa->total_pengajuan }}</td>
                        <td class="table-cell">{{ $siswa->total_approved }}</td>
                        <td class="table-cell">
                            @if($siswa->total_terlambat > 0)
                                <span class="badge-hilang">{{ $siswa->total_terlambat }}</span>
                            @else
                                <span class="badge-dikembalikan">0</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Siswa dengan Keterlambatan -->
    @if($siswa_terlambat->count() > 0)
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Siswa dengan Keterlambatan Pengembalian</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="table-header">NISN</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header">Kelas</th>
                        <th class="table-header">Total Keterlambatan</th>
                        <th class="table-header">Total Pengajuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($siswa_terlambat as $siswa)
                    <tr>
                        <td class="table-cell">{{ $siswa->nisn }}</td>
                        <td class="table-cell font-medium">{{ $siswa->nama }}</td>
                        <td class="table-cell">{{ $siswa->kelas }}</td>
                        <td class="table-cell">
                            <span class="badge-hilang">{{ $siswa->total_terlambat }}</span>
                        </td>
                        <td class="table-cell">{{ $siswa->total_pengajuan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Semua Siswa -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Semua Siswa</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="table-header">NISN</th>
                        <th class="table-header">Nama</th>
                        <th class="table-header">Kelas</th>
                        <th class="table-header">Total Pengajuan</th>
                        <th class="table-header">Disetujui</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($users as $user)
                    <tr>
                        <td class="table-cell">{{ $user->nisn }}</td>
                        <td class="table-cell">{{ $user->nama }}</td>
                        <td class="table-cell">{{ $user->kelas }}</td>
                        <td class="table-cell">{{ $user->total_pengajuan }}</td>
                        <td class="table-cell">{{ $user->total_approved }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    nav, .no-print { display: none !important; }
}
</style>
@endsection