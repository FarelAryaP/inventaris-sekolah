@extends('layouts.app')

@section('title', 'Pengajuan Saya')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pengajuan Saya</h1>
            <p class="text-gray-600">Daftar semua pengajuan peminjaman barang</p>
        </div>
        <a href="{{ route('user.pengajuan.create') }}" class="btn-primary">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Pengajuan
        </a>
    </div>

    <!-- Table Card -->
    <div class="card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">No</th>
                        <th class="table-header">Barang</th>
                        <th class="table-header">Jumlah</th>
                        <th class="table-header">Tanggal Pengajuan</th>
                        <th class="table-header">Periode Pinjam</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengajuans as $index => $pengajuan)
                    <tr class="hover:bg-gray-50">
                        <td class="table-cell">{{ $pengajuans->firstItem() + $index }}</td>
                        <td class="table-cell font-medium">{{ $pengajuan->barang->nama_barang }}</td>
                        <td class="table-cell">{{ $pengajuan->jumlah }}</td>
                        <td class="table-cell">{{ $pengajuan->tgl_pengajuan->format('d M Y H:i') }}</td>
                        <td class="table-cell">
                            <span class="text-sm">{{ $pengajuan->tgl_mulai->format('d M Y') }}</span>
                            <span class="text-gray-400 mx-1">-</span>
                            <span class="text-sm">{{ $pengajuan->tgl_selesai->format('d M Y') }}</span>
                        </td>
                        <td class="table-cell">
                            @if($pengajuan->status == 0)
                                <span class="badge-pending">Pending</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge-approved">Disetujui</span>
                            @else
                                <span class="badge-rejected">Ditolak</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            <a href="{{ route('user.pengajuan.show', $pengajuan) }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 mb-4">Belum ada pengajuan</p>
                            <a href="{{ route('user.pengajuan.create') }}" class="btn-primary">Buat Pengajuan Pertama</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuans->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $pengajuans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection