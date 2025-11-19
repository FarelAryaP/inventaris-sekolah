@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="bi bi-person-plus"></i> Tambah Siswa Baru
            </h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Data Siswa</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN *</label>
                        <input type="number" class="form-control @error('nisn') is-invalid @enderror" 
                               id="nisn" name="nisn" value="{{ old('nisn') }}" 
                               placeholder="Contoh: 1234567890" required>
                        <div class="form-text">Nomor Induk Siswa Nasional (10 digit)</div>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama') }}" 
                               placeholder="Contoh: Ahmad Rizki Pratama" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas *</label>
                        <input type="text" class="form-control @error('kelas') is-invalid @enderror" 
                               id="kelas" name="kelas" value="{{ old('kelas') }}" 
                               placeholder="Contoh: XII IPA 1" required>
                        <div class="form-text">Format: [Tingkat] [Jurusan] [Nomor Kelas]</div>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password *
                            <span class="badge bg-warning text-dark">Wajib</span>
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" 
                               placeholder="Minimal 6 karakter" required>
                        <div class="form-text">Password untuk login siswa ke portal</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" 
                               placeholder="Ketik ulang password" required>
                    </div>

                    <div class="box-btn">
                        <button type="submit" class="btn btn-create">
                             Simpan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-cancel">
                             Batal
                        </a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection