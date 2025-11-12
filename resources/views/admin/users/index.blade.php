@extends('layouts.admin')

@section('title', 'Kelola Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="bi bi-people"></i> Kelola Siswa
                <small class="text-muted">(Super Admin Only)</small>
            </h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="bi bi-person-plus"></i> Tambah Siswa
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Password</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $userItem)
                    <tr>
                        <td>
                            <code>{{ $userItem->nisn }}</code>
                        </td>
                        <td>{{ $userItem->nama }}</td>
                        <td>
                            <span class="badge bg-info">{{ $userItem->kelas }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">
                                <i class="bi bi-shield-check"></i> Set
                            </span>
                        </td>
                        <td>{{ $userItem->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.show', $userItem->nisn) }}" 
                                   class="btn btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $userItem->nisn) }}" 
                                   class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-outline-secondary"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resetPasswordModal{{ $userItem->nisn }}"
                                        title="Reset Password">
                                    <i class="bi bi-key"></i>
                                </button>
                                <form action="{{ route('admin.users.destroy', $userItem->nisn) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus siswa {{ $userItem->nama }}? Semua data pengajuan akan ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Reset Password --}}
                    <div class="modal fade" id="resetPasswordModal{{ $userItem->nisn }}" tabindex="-1" aria-labelledby="resetPasswordModalLabel{{ $userItem->nisn }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resetPasswordModalLabel{{ $userItem->nisn }}">
                                        Reset Password - {{ $userItem->nama }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.users.reset-password', $userItem->nisn) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle"></i>
                                            <strong>NISN:</strong> {{ $userItem->nisn }}<br>
                                            <strong>Nama:</strong> {{ $userItem->nama }}<br>
                                            <strong>Kelas:</strong> {{ $userItem->kelas }}
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password{{ $userItem->nisn }}" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" 
                                                   id="new_password{{ $userItem->nisn }}" 
                                                   name="new_password" 
                                                   placeholder="Minimal 6 karakter"
                                                   required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="new_password_confirmation{{ $userItem->nisn }}" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" 
                                                   id="new_password_confirmation{{ $userItem->nisn }}" 
                                                   name="new_password_confirmation" 
                                                   placeholder="Ketik ulang password"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-key"></i> Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="bi bi-person-x" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="mt-2">Belum ada data siswa</p>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Siswa Pertama
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
    </div>
    <div class="card-footer text-muted">
        <small>Total: {{ $users->total() }} siswa</small>
    </div>
</div>
@endsection
