@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.admins.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Admin</h1>
        <p class="text-gray-600">Perbarui data admin</p>
    </div>

    <!-- Form -->
    <div class="card">
        <form method="POST" action="{{ route('admin.admins.update', $admin->id_admin) }}">
            @csrf
            @method('PUT')

            <!-- Username -->
            <div class="mb-6">
                <label for="username" class="label">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="username" value="{{ old('username', $admin->username) }}"
                       class="input-field {{ $errors->has('username') ? 'input-error' : '' }}" required>
                @error('username')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama -->
            <div class="mb-6">
                <label for="nama" class="label">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $admin->nama) }}"
                       class="input-field {{ $errors->has('nama') ? 'input-error' : '' }}" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label for="id_role" class="label">Role <span class="text-red-500">*</span></label>
                <select name="id_role" id="id_role" class="input-field {{ $errors->has('id_role') ? 'input-error' : '' }}" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}" {{ old('id_role', $admin->id_role) == $role->id_role ? 'selected' : '' }}>
                            {{ $role->nama }} - {{ $role->deskripsi }}
                        </option>
                    @endforeach
                </select>
                @error('id_role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="mb-6">
                <label for="password" class="label">Password Baru</label>
                <input type="password" name="password" id="password"
                       class="input-field {{ $errors->has('password') ? 'input-error' : '' }}" 
                       placeholder="Kosongkan jika tidak ingin mengubah">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="password_confirmation" class="label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="input-field" placeholder="Ulangi password baru">
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.admins.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection