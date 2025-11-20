@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Laporan Peminjaman</h1>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body text-center">
                <h4>{{ $peminjamans->count() }}</h4>
                <p class="mb-0">Total Peminjaman</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body text-center">
                <h4>{{ $peminjamans->where('status', 0)->count() }}</h4>
                <p class="mb-0">Sedang Dipinjam</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body text-center">
                <h4>{{ $peminjamans->where('status', 1)->count() }}</h4>
                <p class="mb-0">Dikembalikan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body text-center">
                <h4>{{ $peminjamans->where('status', 2)->count() }}</h4>
                <p class="mb-0">Hilang</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Detail Laporan Peminjaman</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tgl Mulai</th>
                        <th>Tgl Selesai</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $index => $peminjaman)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peminjaman->pengajuan->user->nama }}</td>
                        <td>{{ $peminjaman->pengajuan->user->kelas }}</td>
                        <td>{{ $peminjaman->pengajuan->barang->nama_barang }}</td>
                        <td>{{ $peminjaman->pengajuan->jumlah }}</td>
                        <td>{{ $peminjaman->tgl_mulai->format('d/m/Y') }}</td>
                        <td>{{ $peminjaman->tgl_selesai->format('d/m/Y') }}</td>
                        <td>
                            @if($peminjaman->status == 0)
                                <span class="badge bg-primary">Dipinjam</span>
                            @elseif($peminjaman->status == 1)
                                <span class="badge bg-success">Dikembalikan</span>
                            @else
                                <span class="badge bg-warning">Hilang</span>
                            @endif
                        </td>
                        <td>
                            @if($peminjaman->status == 0 && $peminjaman->tgl_selesai < now())
                                <span class="text-danger">Terlambat</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted">
        <small>Laporan dibuat pada {{ now()->format('d/m/Y H:i') }}</small>
    </div>
</div>
@endsection

@push('scripts')
<style>
@media print {
    .btn, .navbar, .card-footer {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    body {
        font-size: 12px;
    }
    
    table {
        font-size: 11px;
    }
}
</style>
@endpush