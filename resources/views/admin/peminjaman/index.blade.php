@extends('layouts.admin')

@section('title', 'Data Peminjaman')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Data Peminjaman</h1>
        <p class="text-gray-600">Kelola data peminjaman barang yang sedang berlangsung</p>
    </div>

    <div class="card p-0 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">No</th>
                        <th class="table-header">Siswa</th>
                        <th class="table-header">Barang</th>
                        <th class="table-header">Jumlah</th>
                        <th class="table-header">Tgl Mulai</th>
                        <th class="table-header">Tgl Selesai</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($peminjamans as $index => $peminjaman)
                    <tr class="hover:bg-gray-50">
                        <td class="table-cell">{{ $peminjamans->firstItem() + $index }}</td>
                        <td class="table-cell">
                            <div>
                                <p class="font-medium">{{ $peminjaman->pengajuan->user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $peminjaman->pengajuan->user->kelas }}</p>
                            </div>
                        </td>
                        <td class="table-cell font-medium">{{ $peminjaman->pengajuan->barang->nama_barang }}</td>
                        <td class="table-cell">{{ $peminjaman->pengajuan->jumlah }}</td>
                        <td class="table-cell">{{ $peminjaman->tgl_mulai->format('d M Y') }}</td>
                        <td class="table-cell">
                            <span class="{{ $peminjaman->tgl_selesai < now() && $peminjaman->status == 0 ? 'text-red-600 font-semibold' : '' }}">
                                {{ $peminjaman->tgl_selesai->format('d M Y') }}
                            </span>
                            @if($peminjaman->tgl_selesai < now() && $peminjaman->status == 0)
                                <span class="text-xs text-red-500 block">Terlambat</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            @if($peminjaman->status == 0)
                                <span class="badge-dipinjam">Dipinjam</span>
                            @elseif($peminjaman->status == 1)
                                <span class="badge-dikembalikan">Dikembalikan</span>
                            @else
                                <span class="badge-hilang">Hilang</span>
                            @endif
                        </td>
                        <td class="table-cell">
                            <a href="{{ route('admin.peminjaman.show', $peminjaman) }}" class="text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <svg class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500">Belum ada data peminjaman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($peminjamans->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t">
            {{ $peminjamans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection