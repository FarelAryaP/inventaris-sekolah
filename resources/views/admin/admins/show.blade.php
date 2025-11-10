@extends('layouts.admin')

@section('title', 'Detail Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="bi bi-person-badge"></i> Detail Admin: {{ $admin->nama }}
    </h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        
        @if(auth()->guard('admin')->user()->id_role == 1 && 
            $admin->id_admin != auth()->guard('admin')->id())
            <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Edit
            </a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Admin</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Username</strong></td>
                        <td>:</td>
                        <td><code>{{ $admin->username }}</code></td>
                    </tr>
                    <tr>
                        <td><strong>Nama Lengkap</strong></td>
                        <td>:</td>
                        <td>{{ $admin->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Role</strong></td>
                        <td>:</td>
                        <td>
                            @if($admin->role)
                                <span class="badge bg-{{ $admin->id_role == 1 ? 'warning text-dark' : 'secondary' }}">
                                    {{ $admin->role->nama }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat</strong></td>
                        <td>:</td>
                        <td>{{ $admin->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Terakhir Update</strong></td>
                        <td>:</td>
                        <td>{{ $admin->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Riwayat Pengajuan</h5>
            </div>
            <div class="card-body">
                @if($admin->pengajuan->count() > 0)
                    <ul class="list-group">
                        @foreach($admin->pengajuan as $pengajuan)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">ID: {{ $pengajuan->id_pengajuan }}</div>
                                    <small class="text-muted">
                                        {{ $pengajuan->barang->nama_barang }} ({{ $pengajuan->jumlah }})
                                    </small>
                                </div>
                                <span class="badge bg-{{ 
                                    $pengajuan->status == 1 ? 'success' : 
                                    ($pengajuan->status == 2 ? 'danger' : 'warning') 
                                }}">
                                    {{ $pengajuan->status_text }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center mt-3">Belum ada pengajuan yang diproses.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection