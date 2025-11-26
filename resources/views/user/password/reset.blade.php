@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-lg mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Ganti Password</h1>
        <p class="text-gray-600">Perbarui password akun Anda</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form method="POST" action="{{ route('user.password.reset') }}">
            @csrf
            @method('PATCH')

            <!-- Password Saat Ini -->
            <div class="mb-6">
                <label for="current_password" class="label">Password Saat Ini <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" id="current_password"
                       class="input-field @error('current_password') input-error @enderror" 
                       placeholder="Masukkan password saat ini" required>
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Baru -->
            <div class="mb-6">
                <label for="new_password" class="label">Password Baru <span class="text-red-500">*</span></label>
                <input type="password" name="new_password" id="new_password"
                       class="input-field @error('new_password') input-error @enderror" 
                       placeholder="Masukkan password baru" required>
                @error('new_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Minimal 8 karakter</p>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label for="new_password_confirmation" class="label">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                       class="input-field" 
                       placeholder="Ulangi password baru" required>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>

    <!-- Info -->
    <div class="alert-info">
        <div class="flex">
            <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm">
                <p class="font-medium">Tips keamanan password:</p>
                <ul class="list-disc list-inside mt-1 text-blue-700">
                    <li>Gunakan kombinasi huruf, angka, dan simbol</li>
                    <li>Jangan gunakan informasi pribadi</li>
                    <li>Jangan bagikan password kepada siapapun</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection