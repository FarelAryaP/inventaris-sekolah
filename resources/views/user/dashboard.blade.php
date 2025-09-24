@extends('layouts.user')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">Dashboard - Selamat datang, {{ $user->nama }}!</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_pengajuan'] }}</h4>
                        <p class="card-text">Total Pengajuan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-file-text" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['pengajuan_pending'] }}</h4>
                        <p class="card-text">Menunggu Persetujuan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['pengajuan_approved'] }}</h4>
                        <p class="card-text">Disetujui</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['barang_tersedia'] }}</h4>
                        <p class="card-text">Barang Tersedia</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pengajuan Terbaru -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pengajuan Terbaru Saya</h5>
                <a href="{{ route('user.pengajuan.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($pengajuan_terbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan_terbaru as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->barang->nama_barang }}</td>
                                    <td>{{ $pengajuan->jumlah }}</td>
                                    <td>
                                        @if($pengajuan->status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($pengajuan->status == 1)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('user.pengajuan.show', $pengajuan) }}" 
                                           class="btn btn-sm btn-outline-primary">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada pengajuan</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Barang Tersedia -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Barang Tersedia</h5>
                <a href="{{ route('user.pengajuan.create') }}" class="btn btn-sm btn-success">Ajukan</a>
            </div>
            <div class="card-body">
                @if($barang_tersedia->count() > 0)
                    @foreach($barang_tersedia as $barang)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>{{ $barang->nama_barang }}</strong><br>
                            <small class="text-muted">Stok: {{ $barang->jumlah }}</small>
                        </div>
                        <span class="badge bg-success">Tersedia</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Tidak ada barang tersedia</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection