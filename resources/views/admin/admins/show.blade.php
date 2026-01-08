@extends('layouts.admin')

@section('title', 'Detail Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.admins.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Detail Admin</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.admins.edit', $admin->id_admin) }}" class="btn-secondary btn-sm">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                @if($admin->id_admin != Auth::guard('admin')->user()->id_admin)
                <form action="{{ route('admin.admins.destroy', $admin->id_admin) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger btn-sm">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Admin -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Informasi Admin</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">ID Admin</p>
                <p class="font-medium text-gray-900">#{{ $admin->id_admin }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Username</p>
                <p class="font-medium text-gray-900">{{ $admin->username }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Nama Lengkap</p>
                <p class="font-medium text-gray-900">{{ $admin->nama }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Role</p>
                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $admin->id_role == 1 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $admin->role->nama }}
                </span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Terdaftar Sejak</p>
                <p class="font-medium text-gray-900">{{ $admin->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Terakhir Diupdate</p>
                <p class="font-medium text-gray-900">{{ $admin->updated_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Reset Password -->
    @if($admin->id_admin != Auth::guard('admin')->user()->id_admin)
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Reset Password</h2>
        <form method="POST" action="{{ route('admin.admins.reset-password', $admin->id_admin) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="label">Password Baru</label>
                    <input type="password" name="password" id="password" 
                           class="input-field {{ $errors->has('password') ? 'input-error' : '' }}" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
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
    @endif

    <!-- Riwayat Pengajuan yang Diproses -->
    <div class="card">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 pb-4 border-b">Riwayat Pengajuan yang Diproses</h2>
        
        @if($admin->pengajuan->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="table-header">Siswa</th>
                        <th class="table-header">Barang</th>
                        <th class="table-header">Tanggal</th>
                        <th class="table-header">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($admin->pengajuan->take(10) as $pengajuan)
                    <tr>
                        <td class="table-cell">{{ $pengajuan->user->nama }}</td>
                        <td class="table-cell">{{ $pengajuan->barang->nama_barang }}</td>
                        <td class="table-cell">{{ $pengajuan->updated_at->format('d M Y') }}</td>
                        <td class="table-cell">
                            @if($pengajuan->status == 1)
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
        <p class="text-center text-gray-500 py-4">Belum ada riwayat pengajuan yang diproses</p>
        @endif
    </div>
</div>
@endsection