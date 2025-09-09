@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">Dashboard Admin</h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $stats['total_barang'] }}</h4>
                        <p class="card-text">Total Barang</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
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
                        <h4 class="card-title">{{ $stats['total_siswa'] }}</h4>
                        <p class="card-text">Total Siswa</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-people" style="font-size: 2rem;"></i>
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
                        <p class="card-text">Pengajuan Pending</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock" style="font-size: 2rem;"></i>
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
                        <h4 class="card-title">{{ $stats['barang_dipinjam'] }}</h4>
                        <p class="card-text">Barang Dipinjam</p>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-arrow-repeat" style="font-size: 2rem;"></i>
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
                <h5 class="card-title mb-0">Pengajuan Terbaru</h5>
                <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($pengajuan_terbaru->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuan_terbaru as $pengajuan)
                                <tr>
                                    <td>{{ $pengajuan->user->nama }}</td>
                                    <td>{{ $pengajuan->barang->nama_barang }}</td>
                                    <td>{{ $pengajuan->jumlah }}</td>
                                    <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" 
                                           class="btn btn-sm btn-outline-primary">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Tidak ada pengajuan pending</p>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Stok Rendah -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Stok Rendah</h5>
            </div>
            <div class="card-body">
                @if($barang_stok_rendah->count() > 0)
                    @foreach($barang_stok_rendah as $barang)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>{{ $barang->nama_barang }}</strong><br>
                            <small class="text-muted">Stok: {{ $barang->jumlah }}</small>
                        </div>
                        <span class="badge bg-warning">Rendah</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">Semua barang stoknya cukup</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection