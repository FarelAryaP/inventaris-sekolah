@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('user.pengajuan.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
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

    <!-- Detail Card -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Pengajuan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Barang</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->barang->nama_barang }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Jumlah Pinjam</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->jumlah }} unit</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->tgl_pengajuan->format('d M Y, H:i') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-medium">
                    @if($pengajuan->status == 0)
                        <span class="text-yellow-600">Menunggu Persetujuan</span>
                    @elseif($pengajuan->status == 1)
                        <span class="text-green-600">Disetujui</span>
                    @else
                        <span class="text-red-600">Ditolak</span>
                    @endif
                </p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Mulai Pinjam</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->tgl_mulai->format('d M Y') }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Tanggal Selesai Pinjam</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->tgl_selesai->format('d M Y') }}</p>
            </div>

            @if($pengajuan->admin)
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Diproses Oleh</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->admin->nama }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Info Barang -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Barang</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Nama Barang</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->barang->nama_barang }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Stok Tersedia</p>
                <p class="font-medium {{ $pengajuan->barang->jumlah < 5 ? 'text-red-600' : 'text-green-600' }}">
                    {{ $pengajuan->barang->jumlah }} unit
                </p>
            </div>

            @if($pengajuan->barang->keterangan)
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Keterangan</p>
                <p class="font-medium text-gray-900">{{ $pengajuan->barang->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Status Timeline -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Status Pengajuan</h2>
        
        <div class="space-y-4">
            <!-- Step 1: Diajukan -->
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="font-medium text-gray-900">Pengajuan Dibuat</p>
                    <p class="text-sm text-gray-500">{{ $pengajuan->tgl_pengajuan->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Step 2: Diproses -->
            <div class="flex items-start">
                <div class="flex-shrink-0 h-8 w-8 rounded-full {{ $pengajuan->status != 0 ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center">
                    @if($pengajuan->status != 0)
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <div class="h-3 w-3 rounded-full bg-white"></div>
                    @endif
                </div>
                <div class="ml-4">
                    <p class="font-medium {{ $pengajuan->status != 0 ? 'text-gray-900' : 'text-gray-400' }}">
                        @if($pengajuan->status == 1)
                            Disetujui
                        @elseif($pengajuan->status == 2)
                            Ditolak
                        @else
                            Menunggu Persetujuan
                        @endif
                    </p>
                    @if($pengajuan->status != 0)
                        <p class="text-sm text-gray-500">{{ $pengajuan->updated_at->format('d M Y, H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection