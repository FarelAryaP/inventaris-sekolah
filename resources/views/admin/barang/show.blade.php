@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')

<div class="barang-info">
    <div class="detail-barang">
        <h3>Detail Barang</h3>
            
        <div class="btn-editbarang">
            <a href="{{ route('admin.barang.edit', $barang) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            </div>
        </div>

    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="info-barang">
            <tr>
                <td class="fw-bold">ID Barang</td>
                <td>: {{ $barang->id_barang }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Nama Barang</td>
                <td>: {{ $barang->nama_barang }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Jumlah</td>
                <td>: 
                <span class="badge {{ $barang->jumlah < 5 ? 'bg-warning' : 'bg-success' }} fs-6">
                    {{ $barang->jumlah }}
                </span>
                </td>
            </tr>
            <tr>
                <td class="fw-bold">Dibuat</td>
                <td>: {{ $barang->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td class="fw-bold">Diupdate</td>
                <td>: {{ $barang->updated_at->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <label class="form-label fw-bold">Keterangan</label>
            <div class="border rounded p-3 bg-light">
                {{ $barang->keterangan ?: 'Tidak ada keterangan' }}
            </div>
    </div>

    </div>
</div>

<!-- Riwayat Pengajuan -->
<div class="card-riwayat">
    <div class="riwayat-header">
        <h5>Riwayat Pengajuan Barang Ini</h5>
    </div>
    <div class="card-riwayat">
        @if($barang->pengajuan->count() > 0)
        <div class="riwayat-responsive">
            <table class="table-riwayat">
            <thead>
                <tr>
                <th>Siswa</th>
                <th>Jumlah</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
                </tr>
            </thead>
                    
            <tbody>
                @foreach($barang->pengajuan->take(10) as $pengajuan)
                    <tr>
                    <td>{{ $pengajuan->user->nama }}</td>
                    <td>{{ $pengajuan->jumlah }}</td>
                    <td>{{ $pengajuan->tgl_pengajuan->format('d/m/Y') }}</td>
                    <td>
                        @if($pengajuan->status == 0)
                        <span class="badge bg-warning">Pending</span>
                        @elseif($pengajuan->status == 1)
                        <span class="badge bg-success">Approved</span>
                        @else
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    </tr>
                        @endforeach
            </tbody>
            </table>
        </div>
        @else
        <p class="text-muted text-center">Belum ada pengajuan untuk barang ini</p>
        @endif
    </div>
</div>
@endsection