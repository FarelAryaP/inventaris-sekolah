@extends('layouts.admin')

@section('title', 'Detail Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
       {{ $admin->nama }}
    </h2>
        
        @if(auth()->guard('admin')->user()->id_role == 1 && 
            $admin->id_admin != auth()->guard('admin')->id())
        @endif
    </div>
</div>

<div class="info-admin">
    <div class="card-header-admin">
        <h5>Informasi Admin</h5>
    </div>
            
    <div class="card-body-admin">
        <table class="table-admin-detail">
                    <tr>
                        <td class="user"><strong>Username</strong></td>
                        <td>:</td>
                        <td><code>{{ $admin->username }}</code></td>
                    </tr>
                    <tr>
                        <td class="name"><strong>Nama Lengkap</strong></td>
                        <td>:</td>
                        <td>{{ $admin->nama }}</td>
                    </tr>
                    <tr>
                        <td class="role"><strong>Role</strong></td>
                        <td>:</td>
                        <td>
                            @if($admin->role)
                                <span class="badge bg-{{ $admin->id_role == 1 ? 'warning text-dark' : 'secondary' }}">
                                    {{ $admin->role->nama }}
                                </span>
                            @else
                                <span class="text-muted-admin">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="create-tgl"><strong>Dibuat</strong></td>
                        <td>:</td>
                        <td>{{ $admin->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="up-tgl"><strong>Terakhir Update</strong></td>
                        <td>:</td>
                        <td>{{ $admin->updated_at->format('d M Y H:i') }}</td>
                    </tr>
        </table>
    </div>
</div>

    <div class="riwayat-pengajuan-admin">
        <div class="card-header-riwayat">
            <h5>Riwayat Pengajuan</h5>
        </div>
            <div class="card-body-pengajuan">
                @if($admin->pengajuan->count() > 0)
                <ul class="list-group">
                @foreach($admin->pengajuan as $pengajuan)
                <li class="list-group-item">
            <div>
            <div class="fw-bold">ID: {{ $pengajuan->id_pengajuan }}</div>
                <small class="text-muted">
                {{ optional($pengajuan->barang)->nama_barang ?? 'Barang tidak ditemukan' }}
                ({{ $pengajuan->jumlah }})
                </small>
            </div>

            <span class="badge bg-{{ $pengajuan->status == 1 ? 'success' : ($pengajuan->status == 2 ? 'danger' : 'warning') }}">
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
@endsection
