@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Detail Siswa</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary btn-sm">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
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

    <!-- Info Siswa -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Siswa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">NISN</p>
                <p class="font-medium text-gray-900">{{ $user->nisn }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="font-medium text-gray-900">{{ $user->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Kelas</p>
                <p class="font-medium text-gray-900">{{ $user->kelas }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Terdaftar Sejak</p>
                <p class="font-medium text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Reset Password -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Reset Password</h2>
        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}">
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="new_password" class="label">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" 
                           class="input-field {{ $errors->has('new_password') ? 'input-error' : '' }}" required>
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="new_password_confirmation" class="label">Konfirmasi Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                           class="input-field" required>
                </div>
            </div>
            <button type="submit" class="btn-warning mt-4">
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                </svg>
                Reset Password
            </button>
        </form>
    </div>

    <!-- Riwayat Pengajuan -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Riwayat Pengajuan</h2>
        
        @if($user->pengajuan->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">Barang</th>
                        <th class="table-header">Jumlah</th>
                        <th class="table-header">Tanggal</th>
                        <th class="table-header">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($user->pengajuan as $pengajuan)
                    <tr>
                        <td class="table-cell">{{ $pengajuan->barang->nama_barang }}</td>
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