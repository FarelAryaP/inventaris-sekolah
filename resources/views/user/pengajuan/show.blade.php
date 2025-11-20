@extends('layouts.user')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Detail Pengajuan #{{ $pengajuan->id_pengajuan }}</h1>
            <a href="{{ route('user.pengajuan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">ID Pengajuan</td>
                        <td>: {{ $pengajuan->id_pengajuan }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Barang</td>
                        <td>: {{ $pengajuan->barang->nama_barang }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Jumlah</td>
                        <td>: {{ $pengajuan->jumlah }}</td>
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
                                <span class="badge bg-warning fs-6">Menunggu Persetujuan</span>
                            @elseif($pengajuan->status == 1)
                                <span class="badge bg-success fs-6">Disetujui</span>
                            @else
                                <span class="badge bg-danger fs-6">Ditolak</span>
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
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="card-title">Status Timeline</h6>
                        <div class="timeline">
                            <div class="timeline-item active">
                                <i class="bi bi-check-circle text-success"></i>
                                <span>Pengajuan dibuat</span>
                                <small class="text-muted d-block">{{ $pengajuan->tgl_pengajuan->format('d/m/Y H:i') }}</small>
                            </div>
                            <div class="timeline-item {{ $pengajuan->status != 0 ? 'active' : '' }}">
                                @if($pengajuan->status == 1)
                                    <i class="bi bi-check-circle text-success"></i>
                                    <span>Disetujui</span>
                                @elseif($pengajuan->status == 2)
                                    <i class="bi bi-x-circle text-danger"></i>
                                    <span>Ditolak</span>
                                @else
                                    <i class="bi bi-clock text-warning"></i>
                                    <span>Menunggu persetujuan</span>
                                @endif
                                @if($pengajuan->updated_at != $pengajuan->created_at)
                                    <small class="text-muted d-block">{{ $pengajuan->updated_at->format('d/m/Y H:i') }}</small>
                                @endif
                            </div>
                            @if($pengajuan->status == 1 && $pengajuan->detailPeminjaman)
                            <div class="timeline-item {{ $pengajuan->detailPeminjaman->status == 1 ? 'active' : '' }}">
                                @if($pengajuan->detailPeminjaman->status == 1)
                                    <i class="bi bi-check-circle text-success"></i>
                                    <span>Dikembalikan</span>
                                @elseif($pengajuan->detailPeminjaman->status == 2)
                                    <i class="bi bi-exclamation-triangle text-warning"></i>
                                    <span>Hilang</span>
                                @else
                                    <i class="bi bi-arrow-repeat text-primary"></i>
                                    <span>Sedang dipinjam</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($pengajuan->status == 1 && $pengajuan->detailPeminjaman)
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title">Info Peminjaman</h6>
                        <p><strong>Status:</strong> {{ $pengajuan->detailPeminjaman->status_text }}</p>
                        <p><strong>Mulai:</strong> {{ $pengajuan->detailPeminjaman->tgl_mulai->format('d/m/Y') }}</p>
                        <p><strong>Selesai:</strong> {{ $pengajuan->detailPeminjaman->tgl_selesai->format('d/m/Y') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-item i {
    position: absolute;
    left: -23px;
    top: 2px;
    background: white;
    padding: 2px;
}

.timeline-item.active i {
    color: var(--bs-success) !important;
}
</style>
@endpush