@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
<div class="header-edit">
    <h2>
        Edit Admin: {{ $admin->nama }}
    </h2>
</div>

<div class="card-edit-section">
    <div class="card-body-edit">
        <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" 
                       class="form-control @error('username') is-invalid @enderror" 
                       id="username" 
                       name="username" 
                       value="{{ old('username', $admin->username) }}" 
                       required>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" 
                       class="form-control @error('nama') is-invalid @enderror" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama', $admin->nama) }}" 
                       required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="id_role" class="form-label">Role</label>
                <select class="form-select @error('id_role') is-invalid @enderror" 
                        id="id_role" 
                        name="id_role" 
                        required>
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}" 
                                {{ (old('id_role') ?? $admin->id_role) == $role->id_role ? 'selected' : '' }}>
                            {{ $role->nama }}
                            @if($role->deskripsi)
                                - {{ $role->deskripsi }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('id_role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password Baru (Opsional)</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password">
                <div class="form-text">Biarkan kosong jika tidak ingin mengganti password.</div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Update Admin
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>

        <hr class="my-4">

        <h5>Reset Password</h5>
        <form action="{{ route('admin.admins.reset-password', $admin) }}" method="POST" class="mt-3">
            @csrf
            @method('PATCH')
            
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" 
                       class="form-control" 
                       id="new_password" 
                       name="password" 
                       required>
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" 
                       class="form-control" 
                       id="new_password_confirmation" 
                       name="password_confirmation" 
                       required>
            </div>

            <button type="submit" class="btn btn-warning" 
                    onclick="return confirm('Reset password admin ini?')">
                <i class="bi bi-lock-reset"></i> Reset Password
            </button>
        </form>
    </div>
</div>
@endsection