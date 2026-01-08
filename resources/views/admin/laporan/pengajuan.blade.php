@extends('layouts.admin')

@section('title', 'Laporan Pengajuan')

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
            <h1 class="text-2xl font-bold text-gray-900">Laporan Pengajuan</h1>
            <p class="text-gray-600">Data pengajuan peminjaman barang</p>
        </div>
        <button onclick="window.print()" class="btn-secondary btn-sm no-print">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="card">
            <p class="text-sm text-gray-600">Total Pengajuan</p>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Disetujui</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Ditolak</p>
            <p class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</p>
        </div>
        <div class="card">
            <p class="text-sm text-gray-600">Approval Rate</p>
            <p class="text-2xl font-bold text-blue-600">{{ $stats['approval_rate'] }}%</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="card">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="label">Status</label>
                <select name="status" class="input-field">
                    <option value="">Semua Status</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Disetujui</option>
                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div>
                <label class="label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="input-field">
            </div>
            <div>
                <label class="label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" class="input-field">
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn-primary w-full">Filter</button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">No</th>
                        <th class="table-header">Tanggal</th>
                        <th class="table-header">Siswa</th>
                        <th class="table-header">Barang</th>
                        <th class="table-header">Jumlah</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Diproses Oleh</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengajuans as $index => $pengajuan)
                    <tr>
                        <td class="table-cell">{{ $pengajuans->firstItem() + $index }}</td>
                        <td class="table-cell">{{ $pengajuan->tgl_pengajuan->format('d M Y') }}</td>
                        <td class="table-cell">
                            <div>
                                <p class="font-medium">{{ $pengajuan->user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $pengajuan->user->kelas }}</p>
                            </div>
                        </td>
                        <td class="table-cell">{{ $pengajuan->barang->nama_barang }}</td>
                        <td class="table-cell">{{ $pengajuan->jumlah }}</td>
                        <td class="table-cell">
                            @if($pengajuan->status == 0)
                                <span class="badge-pending">Pending</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge-approved">Disetujui</span>
                            @else
                                <span class="badge-rejected">Ditolak</span>
                            @endif
                        </td>
                        <td class="table-cell">{{ $pengajuan->admin ? $pengajuan->admin->nama : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengajuans->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t">
            {{ $pengajuans->links() }}
        </div>
        @endif
    </div>
</div>

<style>
@media print {
    nav, .no-print { display: none !important; }
}
</style>
@endsection