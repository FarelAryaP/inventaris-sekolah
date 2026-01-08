@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.peminjaman.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Detail Peminjaman</h1>
            @if($peminjaman->status == 0)
                <span class="badge-dipinjam text-sm px-3 py-1">Dipinjam</span>
            @elseif($peminjaman->status == 1)
                <span class="badge-dikembalikan text-sm px-3 py-1">Dikembalikan</span>
            @else
                <span class="badge-hilang text-sm px-3 py-1">Hilang</span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Siswa</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Siswa</p>
                    <p class="font-medium text-gray-900">{{ $peminjaman->pengajuan->user->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">NISN</p>
                    <p class="font-medium text-gray-900">{{ $peminjaman->pengajuan->user->nisn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-medium text-gray-900">{{ $peminjaman->pengajuan->user->kelas }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Barang</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Barang</p>
                    <p class="font-medium text-gray-900">{{ $peminjaman->pengajuan->barang->nama_barang }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jumlah Dipinjam</p>
                    <p class="font-medium text-gray-900">{{ $peminjaman->pengajuan->jumlah }} unit</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stok Saat Ini</p>
                    <p class="font-medium text-gray-900">{{ $peminjaman->pengajuan->barang->jumlah }} unit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Detail Peminjaman</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Tanggal Mulai</p>
                <p class="font-medium text-gray-900">{{ $peminjaman->tgl_mulai->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Selesai</p>
                <p class="font-medium {{ $peminjaman->tgl_selesai < now() && $peminjaman->status == 0 ? 'text-red-600' : 'text-gray-900' }}">
                    {{ $peminjaman->tgl_selesai->format('d M Y') }}
                    @if($peminjaman->tgl_selesai < now() && $peminjaman->status == 0)
                        <span class="text-xs block">(Terlambat)</span>
                    @endif
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-medium">
                    @if($peminjaman->status == 0)
                        <span class="text-blue-600">Sedang Dipinjam</span>
                    @elseif($peminjaman->status == 1)
                        <span class="text-green-600">Sudah Dikembalikan</span>
                    @else
                        <span class="text-red-600">Dilaporkan Hilang</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if($peminjaman->status == 0)
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Aksi</h2>
        <div class="flex flex-col sm:flex-row gap-4">
            <form action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full btn-success" onclick="return confirm('Konfirmasi pengembalian?')">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Konfirmasi Dikembalikan
                </button>
            </form>
            <form action="{{ route('admin.peminjaman.hilang', $peminjaman) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full btn-danger" onclick="return confirm('Tandai sebagai hilang?')">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Tandai Hilang
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection