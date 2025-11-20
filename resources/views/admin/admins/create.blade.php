@extends('layouts.admin')

@section('title', 'Tambah Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-person-plus"></i> Tambah Admin Baru
    </h2>
    <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" 
                       class="form-control @error('username') is-invalid @enderror" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}" 
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
                       value="{{ old('nama') }}" 
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
                                {{ old('id_role') == $role->id_role ? 'selected' : '' }}>
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
                <label for="password" class="form-label">Password</label>
                <input type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       id="password" 
                       name="password" 
                       required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Simpan Admin
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection