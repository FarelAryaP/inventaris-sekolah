@extends('layouts.admin')

@section('title', 'Edit Siswa')

@section('content')
<div class="card-edit-siswa">
    <div class="card-header">
        <h5>Form Edit Data Siswa</h5>
    </div>
            
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="number" class="form-control" id="nisn" 
                               value="{{ $user->nisn }}" readonly disabled>
                        <div class="form-text">
                            NISN tidak dapat diubah
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" 
                               value="{{ old('nama', $user->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas *</label>
                        <input type="text" class="form-control @error('kelas') is-invalid @enderror" 
                               id="kelas" name="kelas" 
                               value="{{ old('kelas', $user->kelas) }}" required>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="alert alert-warning">
                        <strong>Perhatian:</strong> Kosongkan field password jika tidak ingin mengubahnya. 
                        Untuk reset password, gunakan tombol "Reset Password" di halaman daftar siswa.
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password Baru (Opsional)
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="Kosongkan jika tidak ingin mengubah">
                        <div class="form-text">Minimal 6 karakter jika diisi</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="Ketik ulang password baru">
                    </div>

                    <div class="box-btn">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection