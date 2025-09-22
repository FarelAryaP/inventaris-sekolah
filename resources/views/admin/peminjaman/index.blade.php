@extends('layouts.admin')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Kelola Peminjaman</h1>
            <a href="{{ route('admin.laporan.peminjaman') }}" class="btn btn-info">
                <i class="bi bi-file-earmark-text"></i> Laporan
            </a>
        </div>
    </div>
</div>

<!-- Filter Status -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
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
                        <p class="mb-0">Sudah Dikembalikan</p>
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
            <div class="col-md-3">
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <h4>{{ $peminjamans->count() }}</h4>
                        <p class="mb-0">Total Peminjaman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Siswa</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $peminjaman)
                    <tr>
                        <td>{{ $peminjaman->id_peminjaman }}</td>
                        <td>
                            <strong>{{ $peminjaman->pengajuan->user->nama }}</strong><br>
                            <small class="text-muted">NISN: {{ $peminjaman->pengajuan->user->nisn }}</small><br>
                            <small class="text-muted">Kelas: {{ $peminjaman->pengajuan->user->kelas }}</small>
                        </td>
                        <td>{{ $peminjaman->pengajuan->barang->nama_barang }}</td>
                        <td>{{ $peminjaman->pengajuan->jumlah }}</td>
                        <td>
                            {{ $peminjaman->tgl_mulai->format('d/m/Y') }} - 
                            {{ $peminjaman->tgl_selesai->format('d/m/Y') }}
                            @if($peminjaman->status == 0 && $peminjaman->tgl_selesai < now())
                                <br><small class="text-danger"><i class="bi bi-exclamation-triangle"></i> Terlambat</small>
                            @endif
                        </td>
                        <td>
                            @if($peminjaman->status == 0)
                                <span class="badge bg-primary">Sedang Dipinjam</span>
                            @elseif($peminjaman->status == 1)
                                <span class="badge bg-success">Dikembalikan</span>
                            @else
                                <span class="badge bg-warning">Hilang</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.peminjaman.show', $peminjaman) }}" 
                                   class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($peminjaman->status == 0)
                                    <form action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-success" 
                                                onclick="return confirm('Konfirmasi pengembalian barang?')">
                                            <i class="bi bi-arrow-return-left"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.peminjaman.hilang', $peminjaman) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-warning" 
                                                onclick="return confirm('Konfirmasi barang hilang?')">
                                            <i class="bi bi-exclamation-triangle"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $peminjamans->links() }}
        </div>
    </div>
</div>
@endsection