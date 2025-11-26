@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-xl shadow-lg p-6 text-white">
        <h1 class="text-2xl md:text-3xl font-bold">Selamat Datang, {{ $user->nama }}! 👋</h1>
        <p class="mt-2 text-primary-100">Kelas: {{ $user->kelas }} | NISN: {{ $user->nisn }}</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_pengajuan'] }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pengajuan_pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Disetujui</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pengajuan_approved'] }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Barang Tersedia</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['barang_tersedia'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengajuan Terbaru -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Pengajuan Terbaru</h2>
                <a href="{{ route('user.pengajuan.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($pengajuan_terbaru as $pengajuan)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-medium text-gray-900">{{ $pengajuan->barang->nama_barang }}</p>
                        <p class="text-sm text-gray-500">{{ $pengajuan->tgl_pengajuan->format('d M Y') }}</p>
                    </div>
                    @if($pengajuan->status == 0)
                        <span class="badge-pending">Pending</span>
                    @elseif($pengajuan->status == 1)
                        <span class="badge-approved">Disetujui</span>
                    @else
                        <span class="badge-rejected">Ditolak</span>
                    @endif
                </div>
                @empty
                <p class="text-center text-gray-500 py-8">Belum ada pengajuan</p>
                @endforelse
            </div>
        </div>

        <!-- Barang Tersedia -->
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Barang Tersedia</h2>
                <a href="{{ route('user.pengajuan.create') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">Ajukan Peminjaman →</a>
            </div>
            <div class="space-y-3">
                @forelse($barang_tersedia as $barang)
                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-medium text-gray-900">{{ $barang->nama_barang }}</p>
                        <p class="text-sm text-gray-500">{{ Str::limit($barang->keterangan, 30) }}</p>
                    </div>
                    <span class="text-sm font-semibold {{ $barang->jumlah < 5 ? 'text-red-600' : 'text-green-600' }}">
                        Stok: {{ $barang->jumlah }}
                    </span>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8">Tidak ada barang tersedia</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('user.pengajuan.create') }}" class="flex items-center p-4 bg-primary-50 hover:bg-primary-100 rounded-lg transition">
                <svg class="h-10 w-10 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <div class="ml-4">
                    <p class="font-semibold text-gray-900">Buat Pengajuan</p>
                    <p class="text-sm text-gray-600">Ajukan peminjaman barang</p>
                </div>
            </a>

            <a href="{{ route('user.pengajuan.index') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                <svg class="h-10 w-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <div class="ml-4">
                    <p class="font-semibold text-gray-900">Riwayat Pengajuan</p>
                    <p class="text-sm text-gray-600">Lihat semua pengajuan</p>
                </div>
            </a>

            <a href="{{ route('user.password.reset.form') }}" class="flex items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-10 w-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                <div class="ml-4">
                    <p class="font-semibold text-gray-900">Ganti Password</p>
                    <p class="text-sm text-gray-600">Ubah password akun</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection