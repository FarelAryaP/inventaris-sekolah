@extends('layouts.admin')

@section('title', 'Manajemen Pengajuan')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Pengajuan</h1>
        <p class="text-gray-600">Kelola pengajuan peminjaman barang dari siswa</p>
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
                        <th class="table-header">Tgl Pengajuan</th>
                        <th class="table-header">Periode</th>
                        <th class="table-header">Status</th>
                        <th class="table-header">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengajuans as $index => $pengajuan)
                    <tr class="hover:bg-gray-50">
                        <td class="table-cell">{{ $pengajuans->firstItem() + $index }}</td>
                        <td class="table-cell">
                            <div>
                                <p class="font-medium">{{ $pengajuan->user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $pengajuan->user->kelas }}</p>
                            </div>
                        </td>
                        <td class="table-cell font-medium">{{ $pengajuan->barang->nama_barang }}</td>
                        <td class="table-cell">{{ $pengajuan->jumlah }}</td>
                        <td class="table-cell">{{ $pengajuan->tgl_pengajuan->format('d M Y') }}</td>
                        <td class="table-cell">
                            <span class="text-xs">{{ $pengajuan->tgl_mulai->format('d/m/Y') }} - {{ $pengajuan->tgl_selesai->format('d/m/Y') }}</span>
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
                            <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                {{ $pengajuan->status == 0 ? 'Proses' : 'Detail' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <svg class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500">Belum ada pengajuan</p>
                        </td>
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
@endsection