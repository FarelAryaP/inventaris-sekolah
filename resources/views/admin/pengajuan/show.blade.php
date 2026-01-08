@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.pengajuan.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pengajuan</h1>
            @if($pengajuan->status == 0)
                <span class="badge-pending text-sm px-3 py-1">Pending</span>
            @elseif($pengajuan->status == 1)
                <span class="badge-approved text-sm px-3 py-1">Disetujui</span>
            @else
                <span class="badge-rejected text-sm px-3 py-1">Ditolak</span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Siswa</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Siswa</p>
                    <p class="font-medium text-gray-900">{{ $pengajuan->user->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">NISN</p>
                    <p class="font-medium text-gray-900">{{ $pengajuan->user->nisn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kelas</p>
                    <p class="font-medium text-gray-900">{{ $pengajuan->user->kelas }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Barang</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Barang</p>
                    <p class="font-medium text-gray-900">{{ $pengajuan->barang->nama_barang }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Stok Tersedia</p>
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $pengajuan->barang->jumlah < $pengajuan->jumlah ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $pengajuan->barang->jumlah }} unit
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jumlah Diminta</p>
                    <p class="font-medium text-gray-900">{{ $pengajuan->jumlah }} unit</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Detail Pengajuan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->tgl_pengajuan->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Mulai Pinjam</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->tgl_mulai->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Tanggal Selesai Pinjam</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->tgl_selesai->format('d M Y') }}</p>
            </div>
        </div>
        @if($pengajuan->admin)
        <div class="mt-4 pt-4 border-t">
            <p class="text-sm text-gray-500">Diproses Oleh</p>
            <p class="font-medium text-gray-900">{{ $pengajuan->admin->nama }} - {{ $pengajuan->updated_at->format('d M Y, H:i') }}</p>
        </div>
        @endif
    </div>

    @if($pengajuan->status == 0)
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Aksi</h2>
        @if($pengajuan->barang->jumlah < $pengajuan->jumlah)
        <div class="alert-warning mb-4">
            <div class="flex">
                <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p><strong>Perhatian!</strong> Stok tidak mencukupi. Tersedia: {{ $pengajuan->barang->jumlah }}, Diminta: {{ $pengajuan->jumlah }}</p>
            </div>
        </div>
        @endif
        <div class="flex flex-col sm:flex-row gap-4">
            <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full btn-success" {{ $pengajuan->barang->jumlah < $pengajuan->jumlah ? 'disabled' : '' }}
                        onclick="return confirm('Setujui pengajuan ini?')">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Setujui Pengajuan
                </button>
            </form>
            <form action="{{ route('admin.pengajuan.reject', $pengajuan) }}" method="POST" class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full btn-danger" onclick="return confirm('Tolak pengajuan ini?')">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Pengajuan
                </button>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection