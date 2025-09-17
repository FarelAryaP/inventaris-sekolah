@extends('layouts.admin')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detail Pengajuan #{{ $pengajuan->id_pengajuan }}</h1>
            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Pengajuan</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">ID Pengajuan</td>
                        <td>: {{ $pengajuan->id_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Siswa</td>
                        <td>: {{ $pengajuan->user->nama }} (NISN: {{ $pengajuan->user->nisn }})</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kelas</td>
                        <td>: {{ $pengajuan->user->kelas }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Barang</td>
                        <td>: {{ $pengajuan->barang->nama_barang }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Jumlah Diminta</td>
                        <td>: {{ $pengajuan->jumlah }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Stok Tersedia</td>
                        <td>: {{ $pengajuan->barang->jumlah }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Pengajuan</td>
                        <td>: {{ $pengajuan->tgl_pengajuan->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Periode Peminjaman</td>
                        <td>: {{ $pengajuan->tgl_mulai->format('d/m/Y') }} s/d {{ $pengajuan->tgl_selesai->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status</td>
                        <td>: 
                            @if($pengajuan->status == 0)
                                <span class="badge bg-warning fs-6">Pending</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge bg-success fs-6">Approved</span>
                            @else
                                <span class="badge bg-danger fs-6">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @if($pengajuan->admin)
                    <tr>
                        <td class="fw-bold">Diproses oleh</td>
                        <td>: {{ $pengajuan->admin->nama }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        @if($pengajuan->status == 0)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" 
                          method="POST" onsubmit="return confirm('Setujui pengajuan ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Setujui Pengajuan
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.pengajuan.reject', $pengajuan) }}" 
                          method="POST" onsubmit="return confirm('Tolak pengajuan ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-x-circle"></i> Tolak Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Info Peminjaman jika sudah approved -->
        @if($pengajuan->status == 1 && $pengajuan->detailPeminjaman)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Peminjaman</h5>
            </div>
            <div class="card-body">
                <p><strong>Status:</strong> {{ $pengajuan->detailPeminjaman->status_text }}</p>
                <a href="{{ route('admin.peminjaman.show', $pengajuan->detailPeminjaman) }}" 
                   class="btn btn-primary btn-sm">Lihat Detail Peminjaman</a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
