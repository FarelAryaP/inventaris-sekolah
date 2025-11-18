@extends('layouts.admin')

@section('title', 'Tambah Admin')

@section('content')

<div class="card-create">
        <form id="formCreateAdmin" action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            <div class="colomn-">
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

            <div class="colomn">
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

            <div class="colomn">
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

            <div class="colomn">
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

            <div class="colomn">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required>
            </div>

            <div class="sumbit-btn">
                <button type="submit" class="btn-primary">
                    Simpan Admin
                </button>
                <a href="{{ route('admin.admins.index') }}" class="btn-secondary">
                    Batal
                </a>
            </div>
        </form>
</div>
@endsection