@extends('layouts.admin')

@section('title', 'Edit Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="bi bi-pencil-square"></i> Edit Data Siswa
            </h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Form Edit Data Siswa</h5>
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
                            <i class="bi bi-lock"></i> NISN tidak dapat diubah
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
                        <i class="bi bi-exclamation-triangle"></i>
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

                    <div class="d-flex gap-2 mt-4">
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

    <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h6 class="card-title mb-0">
                    <i class="bi bi-person-badge"></i> Info Siswa
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold">NISN:</td>
                        <td><code>{{ $user->nisn }}</code></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Nama:</td>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kelas:</td>
                        <td><span class="badge bg-info">{{ $user->kelas }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Terdaftar:</td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Update Terakhir:</td>
                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-warning mt-3">
            <div class="card-header bg-warning">
                <h6 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Statistik Pengajuan
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td>Total Pengajuan:</td>
                        <td class="text-end"><strong>{{ $user->pengajuan->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td>Pending:</td>
                        <td class="text-end">
                            <span class="badge bg-warning">{{ $user->pengajuan->where('status', 0)->count() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Approved:</td>
                        <td class="text-end">
                            <span class="badge bg-success">{{ $user->pengajuan->where('status', 1)->count() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Rejected:</td>
                        <td class="text-end">
                            <span class="badge bg-danger">{{ $user->pengajuan->where('status', 2)->count() }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection