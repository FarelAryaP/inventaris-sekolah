@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Tambah Siswa Baru</h1>
        <p class="text-gray-600">Buat akun siswa baru</p>
    </div>

    <!-- Form -->
    <div class="card">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf

            <!-- NISN -->
            <div class="mb-6">
                <label for="nisn" class="label">NISN <span class="text-red-500">*</span></label>
                <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                       class="input-field {{ $errors->has('nisn') ? 'input-error' : '' }}" 
                       placeholder="Masukkan NISN" required>
                @error('nisn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div class="mb-6">
                <label for="nama" class="label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                       class="input-field {{ $errors->has('nama') ? 'input-error' : '' }}" 
                       placeholder="Masukkan nama lengkap" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kelas -->
            <div class="mb-6">
                <label for="kelas" class="label">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas" id="kelas" class="input-field {{ $errors->has('kelas') ? 'input-error' : '' }}" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach(['X', 'XI', 'XII'] as $tingkat)
                        @foreach(['RPL 1', 'RPL 2', 'TKJ 1', 'TKJ 2', 'BC 1', 'BC 2'] as $jurusan)
                            <option value="{{ $tingkat }} {{ $jurusan }}" {{ old('kelas') == "$tingkat $jurusan" ? 'selected' : '' }}>
                                {{ $tingkat }} {{ $jurusan }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
                @error('kelas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="label">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="password"
                       class="input-field {{ $errors->has('password') ? 'input-error' : '' }}" 
                       placeholder="Minimal 6 karakter" required>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="label">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="input-field" placeholder="Ulangi password" required>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection