@extends('layouts.user')

@section('title', 'Pengajuan Saya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Pengajuan Saya</h1>
            <a href="{{ route('user.pengajuan.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Ajukan Barang
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
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuans as $pengajuan)
                    <tr>
                        <td>{{ $pengajuan->barang->nama_barang }}</td>
                        <td>{{ $pengajuan->jumlah }}</td>
                        <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                        <td>
                            {{ $pengajuan->tgl_mulai->format('d/m/Y') }} - 
                            {{ $pengajuan->tgl_selesai->format('d/m/Y') }}
                        </td>
                        <td>
                            @if($pengajuan->status == 0)
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.pengajuan.show', $pengajuan) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> Detail
                            </a>
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
