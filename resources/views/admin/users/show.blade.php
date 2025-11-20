@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">
                <i class="bi bi-person-circle"></i> Detail Data Siswa
            </h1>
            <div class="btn-group">
                <a href="{{ route('admin.users.edit', $user->nisn) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-person-badge"></i> Informasi Siswa
                </h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle text-primary" style="font-size: 5rem;"></i>
                </div>
                <h4 class="mb-1">{{ $user->nama }}</h4>
                <p class="text-muted mb-2">
                    <code class="fs-6">{{ $user->nisn }}</code>
                </p>
                <span class="badge bg-info fs-6">{{ $user->kelas }}</span>
            </div>
            <div class="card-footer">
                <small class="text-muted">
                    <i class="bi bi-calendar-plus"></i> Terdaftar: {{ $user->created_at->format('d/m/Y') }}
                </small>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-shield-check"></i> Status Akun
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Password:</span>
                    <span class="badge bg-success">Set</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Status:</span>
                    <span class="badge bg-success">Active</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Last Update:</span>
                    <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                </div>
                
                <hr>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-toggle="modal" 
                            data-bs-target="#resetPasswordModal">
                        <i class="bi bi-key"></i> Reset Password
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clipboard-data"></i> Riwayat Pengajuan
                </h5>
            </div>
            <div class="card-body">
                @if($user->pengajuan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->pengajuan->sortByDesc('created_at') as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->id_pengajuan }}</td>
                                    <td>{{ $pengajuan->barang->nama_barang ?? 'N/A' }}</td>
                                    <td>{{ $pengajuan->jumlah }}</td>
                                    <td>
                                        @if($pengajuan->tgl_pengajuan)
                                            {{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($pengajuan->tgl_mulai && $pengajuan->tgl_selesai)
                                            <small>
                                                {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->format('d/m') }} - 
                                                {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->format('d/m/Y') }}
                                            </small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @switch($pengajuan->status)
                                            @case(0)
                                                <span class="badge bg-warning">Pending</span>
                                                @break
                                            @case(1)
                                                <span class="badge bg-success">Approved</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-danger">Rejected</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Summary Stats --}}
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $user->pengajuan->count() }}</h3>
                                    <small class="text-muted">Total</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning bg-opacity-10">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $user->pengajuan->where('status', 0)->count() }}</h3>
                                    <small class="text-muted">Pending</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success bg-opacity-10">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $user->pengajuan->where('status', 1)->count() }}</h3>
                                    <small class="text-muted">Approved</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger bg-opacity-10">
                                <div class="card-body text-center">
                                    <h3 class="mb-0">{{ $user->pengajuan->where('status', 2)->count() }}</h3>
                                    <small class="text-muted">Rejected</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                        <p class="mt-2">Belum ada riwayat pengajuan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal Reset Password --}}
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password - {{ $user->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.reset-password', $user->nisn) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        Password baru akan diberikan kepada <strong>{{ $user->nama }}</strong> 
                        (NISN: {{ $user->nisn }})
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" 
                               id="new_password" name="new_password" 
                               placeholder="Minimal 6 karakter" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                               id="new_password_confirmation" name="new_password_confirmation" 
                               placeholder="Ketik ulang password" required>
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
@endsection