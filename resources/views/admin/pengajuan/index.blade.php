@extends('layouts.admin')

@section('title', 'Kelola Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">Kelola Pengajuan</h1>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Siswa</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuans as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->id_pengajuan }}</td>
                        <td>
                            <strong>{{ $pengajuan->user->nama }}</strong><br>
                            <small class="text-muted">NISN: {{ $pengajuan->user->nisn }}</small><br>
                            <small class="text-muted">Kelas: {{ $pengajuan->user->kelas }}</small>
                        </td>
                        <td>{{ $pengajuan->barang->nama_barang }}</td>
                        <td>{{ $pengajuan->jumlah }}</td>
                        <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($pengajuan->status == 0)
                                <span class="badge bg-warning">Pending</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" 
                                   class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($pengajuan->status == 0)
                                    <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success" 
                                                onclick="return confirm('Setujui pengajuan ini?')">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.pengajuan.reject', $pengajuan) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Tolak pengajuan ini?')">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $pengajuans->links() }}
        </div>
    </div>
</div>
@endsection
