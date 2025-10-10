@extends('layouts.user')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="d-flex justify-content-center" style="background: linear-gradient(to bottom, #a7d2ff, #d9ecff);">
    <div class="card shadow-lg border-0 w-100" 
     style="max-width: 850px; margin-top: 30px; margin-bottom: 30px; border-radius: 20px;">

        <div class="card-body">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                <h2 class="fw-bold text-dark">Detail Pengajuan</h2>
                <a href="{{ route('user.pengajuan.index') }}" class="btn btn-outline-dark btn-sm" >
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <!-- Card Informasi -->
            <div class="card shadow-sm mb-4 border-1" style="border-radius: 15px;">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0 text-dark">Informasi Pengajuan</h5>
                </div>
                <div class="card-body text-dark">
                    <div class="row gy-2">
                        <div class="col-md-6">
                            <small class="text-muted">ID Pengajuan</small>
                            <div class="fw-bold">{{ $pengajuan->id_pengajuan }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Barang</small>
                            <div class="fw-bold">{{ $pengajuan->barang->nama_barang }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Jumlah</small>
                            <div class="fw-bold">{{ $pengajuan->jumlah }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Tanggal Pengajuan</small>
                            <div class="fw-bold">{{ $pengajuan->tgl_pengajuan->format('d/m/Y H:i') }}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Periode Peminjaman</small>
                            <div class="fw-bold">{{ $pengajuan->tgl_mulai->format('d/m/Y') }} s/d {{ $pengajuan->tgl_selesai->format('d/m/Y') }}</div>
                        </div>
                        @if($pengajuan->admin)
                        <div class="col-md-6">
                            <small class="text-muted">Diproses Oleh</small>
                            <div class="fw-bold">{{ $pengajuan->admin->nama }}</div>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <small class="text-muted">Status</small><br>
                            @if($pengajuan->status == 0)
                                <span class="badge bg-warning text-dark px-3 py-2">Menunggu Persetujuan</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge bg-success px-3 py-2">Disetujui</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Ditolak</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card shadow-sm border-1" style="border-radius: 15px;">
                <div class="card-header bg-light border-0">
                    <h5 class="mb-0 text-dark">Status Proses</h5>
                </div>
                <div class="card-body text-dark">
                    <ul class="timeline">
                        <li class="active">
                            <span>Pengajuan dibuat : </span>
                            <small>{{ $pengajuan->tgl_pengajuan->format('d/m/Y H:i') }}</small>
                        </li>
                        <li class="{{ $pengajuan->status != 0 ? 'active' : '' }}">
                            <span>
                                @if($pengajuan->status == 1)
                                    Disetujui :
                                @elseif($pengajuan->status == 2)
                                    Ditolak :
                                @else
                                    Menunggu Persetujuan :
                                @endif
                            </span>
                            @if($pengajuan->updated_at != $pengajuan->created_at)
                                <small>{{ $pengajuan->updated_at->format('d/m/Y H:i') }}</small>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    list-style: none;
    border-left: 3px solid #0d6efd;
    padding-left: 15px;
    margin-left: 10px;
}

.timeline li {
    margin-bottom: 20px;
    position: relative;
}

.timeline li::before {
    content: '';
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #0d6efd;
    position: absolute;
    left: -24px;
    top: 5px;
}

.timeline li.active::before {
    background: #198754;
}

.btn-outline-dark:hover {
    background: black;
    color: white;
}
</style>
@endpush
