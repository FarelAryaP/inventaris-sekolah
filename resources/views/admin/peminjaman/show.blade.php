@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detail Peminjaman #{{ $peminjaman->id_peminjaman }}</h1>
            <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Siswa</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $peminjaman->pengajuan->user->nama }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>: {{ $peminjaman->pengajuan->user->nisn }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>: {{ $peminjaman->pengajuan->user->kelas }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold mb-3">Data Barang</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td>Nama Barang</td>
                                <td>: {{ $peminjaman->pengajuan->barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td>: {{ $peminjaman->pengajuan->jumlah }}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>: {{ $peminjaman->pengajuan->barang->keterangan ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h6 class="fw-bold mb-3">Detail Peminjaman</h6>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">ID Peminjaman</td>
                        <td>: {{ $peminjaman->id_peminjaman }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">ID Pengajuan</td>
                        <td>: 
                            <a href="{{ route('admin.pengajuan.show', $peminjaman->pengajuan) }}">
                                #{{ $peminjaman->pengajuan->id_pengajuan }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Mulai</td>
                        <td>: {{ $peminjaman->tgl_mulai->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Tanggal Selesai</td>
                        <td>: {{ $peminjaman->tgl_selesai->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Durasi</td>
                        <td>: {{ $peminjaman->tgl_mulai->diffInDays($peminjaman->tgl_selesai) + 1 }} hari</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Status</td>
                        <td>: 
                            @if($peminjaman->status == 0)
                                <span class="badge bg-primary fs-6">Sedang Dipinjam</span>
                                @if($peminjaman->tgl_selesai < now())
                                    <span class="badge bg-danger fs-6 ms-2">Terlambat</span>
                                @endif
                            @elseif($peminjaman->status == 1)
                                <span class="badge bg-success fs-6">Dikembalikan</span>
                            @else
                                <span class="badge bg-warning fs-6">Hilang</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Dibuat</td>
                        <td>: {{ $peminjaman->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @if($peminjaman->status != 0)
                    <tr>
                        <td class="fw-bold">Diupdate</td>
                        <td>: {{ $peminjaman->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        @if($peminjaman->status == 0)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}" 
                          method="POST" onsubmit="return confirm('Konfirmasi pengembalian barang?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-arrow-return-left"></i> Kembalikan Barang
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.peminjaman.hilang', $peminjaman) }}" 
                          method="POST" onsubmit="return confirm('Konfirmasi barang hilang?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-exclamation-triangle"></i> Laporkan Hilang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Status Card -->
        <div class="card {{ $peminjaman->status == 0 ? 'mt-3' : '' }}">
            <div class="card-header">
                <h5 class="card-title mb-0">Status Peminjaman</h5>
            </div>
            <div class="card-body">
                @if($peminjaman->status == 0)
                    <div class="alert alert-primary">
                        <i class="bi bi-info-circle"></i> Barang sedang dipinjam
                        @if($peminjaman->tgl_selesai < now())
                            <br><small class="text-danger">⚠️ Sudah melewati batas waktu</small>
                        @else
                            <br><small>Sisa waktu: {{ now()->diffInDays($peminjaman->tgl_selesai) }} hari</small>
                        @endif
                    </div>
                @elseif($peminjaman->status == 1)
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle"></i> Barang sudah dikembalikan
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Barang dilaporkan hilang
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection