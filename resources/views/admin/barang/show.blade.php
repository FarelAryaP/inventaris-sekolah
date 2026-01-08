@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.barang.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Detail Barang</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.barang.edit', $barang) }}" class="btn-secondary btn-sm">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('admin.barang.destroy', $barang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger btn-sm">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">ID Barang</p>
                <p class="font-medium text-gray-900">#{{ $barang->id_barang }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Barang</p>
                <p class="font-medium text-gray-900">{{ $barang->nama_barang }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Jumlah Stok</p>
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $barang->jumlah == 0 ? 'bg-red-100 text-red-800' : ($barang->jumlah < 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                    {{ $barang->jumlah }} unit
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Terakhir Diupdate</p>
                <p class="font-medium text-gray-900">{{ $barang->updated_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Keterangan</p>
                <p class="font-medium text-gray-900">{{ $barang->keterangan ?: '-' }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Riwayat Pengajuan Barang Ini</h2>
        @if($barang->pengajuan->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">Siswa</th>
                        <th class="table-header">Jumlah</th>
                        <th class="table-header">Tanggal</th>
                        <th class="table-header">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($barang->pengajuan->take(10) as $pengajuan)
                    <tr>
                        <td class="table-cell">{{ $pengajuan->user->nama }}</td>
                        <td class="table-cell">{{ $pengajuan->jumlah }}</td>
                        <td class="table-cell">{{ $pengajuan->tgl_pengajuan->format('d M Y') }}</td>
                        <td class="table-cell">
                            @if($pengajuan->status == 0)
                                <span class="badge-pending">Pending</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge-approved">Disetujui</span>
                            @else
                                <span class="badge-rejected">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 py-4">Belum ada riwayat pengajuan</p>
        @endif
    </div>
</div>
@endsection