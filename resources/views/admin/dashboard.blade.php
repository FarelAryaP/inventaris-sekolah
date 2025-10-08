@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="dashboard-page">
    <h3 class="page-title">
        Selamat Datang, {{ Auth::guard('admin')->user()->nama }}!
    </h3>

    <!-- Statistics -->
    <div class="stat-grid">
        <div class="stat-card stat-primary">
            <div class="stat-content">
                <div>
                    <h4>{{ $stats['total_barang'] }}</h4>
                    <p>Total Barang</p>
                </div>
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card stat-success">
            <div class="stat-content">
                <div>
                    <h4>{{ $stats['total_siswa'] }}</h4>
                    <p>Total Siswa</p>
                </div>
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="7" r="4"/>
                    <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card stat-warning">
            <div class="stat-content">
                <div>
                    <h4>{{ $stats['pengajuan_pending'] }}</h4>
                    <p>Pengajuan Pending</p>
                </div>
                <div class="icon-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Rows -->
    <div class="main-content">
        <!-- Pengajuan Terbaru -->
        <div class="card">
            <div class="card-header">
                <h5>Pengajuan Terbaru</h5>
            </div>
            <div class="card-body">
                @if($pengajuan_terbaru->count() > 0)
                <div class="table-wrapper">
                    <table class="data-table">
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
                                    <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" class="btn-outline-small">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                    <div class="text-center">
                        <a href="{{ route('admin.pengajuan.index') }}" class="btn-outline">Lihat Semua</a>
                    </div>

                @else
                <p class="text-muted">Tidak ada pengajuan pending</p>
                @endif
            </div>
        </div>

        <!-- Stok Rendah -->
        <div class="card">
            <div class="card-header">
                <h5>Stok Rendah</h5>
            </div>
            <div class="card-body">
                @if($barang_stok_rendah->count() > 0)
                    @foreach($barang_stok_rendah as $barang)
                    <div class="stok-item">
                        <div>
                            <strong>{{ $barang->nama_barang }}</strong><br>
                            <small>Stok: {{ $barang->jumlah }}</small>
                        </div>
                        <span class="badge-warning">Rendah</span>
                    </div>
                    @endforeach
                @else
                <p class="text-muted">Semua barang stoknya cukup</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
