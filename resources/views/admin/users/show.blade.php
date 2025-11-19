@extends('layouts.admin')

@section('title', 'Detail Siswa')

@section('content')

<div class="card-body-siswa">
    <h4 class="nama">{{ $user->nama }}</h4>

    <p class="nisn">
        <code>{{ $user->nisn }}</code>
    </p>

    <span class="badge bg-info kelas">{{ $user->kelas }}</span>

    <small class="tanggal">
        Terdaftar: {{ $user->created_at->format('d/m/Y') }}
    </small>
</div>


<!--info siswa-->
 <div class="col-lg-4">
        <div class="card border-primary">
            <div class="card-header bg-primary">
                <h6> Info Siswa </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr>
                        <td class="fw-bold">NISN:</td>
                        <td><code>{{ $user->nisn }}</code></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Nama:</td>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Kelas:</td>
                        <td><span class="badge bg-info">{{ $user->kelas }}</span></td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Terdaftar:</td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Update Terakhir:</td>
                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card border-warning mt-3">
            <div class="card-header bg-warning">
                <h6>
                    Statistik Pengajuan
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td>Total Pengajuan:</td>
                        <td class="text-end"><strong>{{ $user->pengajuan->count() }}</strong></td>
                    </tr>
                    <tr>
                        <td>Pending:</td>
                        <td class="text-end">
                            <span class="badge bg-warning">{{ $user->pengajuan->where('status', 0)->count() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Approved:</td>
                        <td class="text-end">
                            <span class="badge bg-success">{{ $user->pengajuan->where('status', 1)->count() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Rejected:</td>
                        <td class="text-end">
                            <span class="badge bg-danger">{{ $user->pengajuan->where('status', 2)->count() }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Pengajuan -->
    <div class="card-riwayat">
        <div class="card-header-riwayat">
            <h5>Riwayat Pengajuan</h5>
        </div>
            
        <div class="card-body">
            @if($user->pengajuan->count() > 0)
            <div class="table-responsive">
            <table class="table-riwayat">
            <thead>
                <tr>
                <th>#</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($user->pengajuan->sortByDesc('created_at') as $pengajuan)
            <tr>
            <td>{{ $pengajuan->id_pengajuan }}</td>
            <td>{{ $pengajuan->barang->nama_barang ?? 'N/A' }}</td>
            <td>{{ $pengajuan->jumlah }}</td>
            <td>
                @if($pengajuan->tgl_pengajuan)
                {{ \Carbon\Carbon::parse($pengajuan->tgl_pengajuan)->format('d/m/Y') }}
                @else
                N/A
                @endif
            </td>

            <td>
                @if($pengajuan->tgl_mulai && $pengajuan->tgl_selesai)
                <small>
                {{ \Carbon\Carbon::parse($pengajuan->tgl_mulai)->format('d/m') }} - 
                {{ \Carbon\Carbon::parse($pengajuan->tgl_selesai)->format('d/m/Y') }}
                </small>
                @else
                -
                @endif
            </td>

            <td>
                @switch($pengajuan->status)
                @case(0)
                    <span class="badge bg-warning">Pending</span>
                @break
                @case(1)
                    <span class="badge bg-success">Approved</span>
                @break
                @case(2)
                                                <span class="badge bg-danger">Rejected</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pengajuan.show', $pengajuan) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

    {{-- Summary Stats --}}
    <div class="card-summary">
        <div class="col-md-3">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $user->pengajuan->count() }}</h3>
                <small class="text-muted">Total</small>
            </div>
        </div>
        </div>
                        
        <div class="col-md-3">
        <div class="card bg-warning">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $user->pengajuan->where('status', 0)->count() }}</h3>
                <small class="text-muted">Pending</small>
            </div>
        </div>
        </div>
                        
        <div class="col-md-3">
        <div class="card bg-success">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $user->pengajuan->where('status', 1)->count() }}</h3>
                <small class="text-muted">Approved</small>
            </div>
        </div>
        </div>
                        
        <div class="col-md-3">
        <div class="card bg-danger">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $user->pengajuan->where('status', 2)->count() }}</h3>
                <small class="text-muted">Rejected</small>
            </div>
        </div>
        </div>
    </div>
    @else
                    
    <div class="text-center">
        <p class="mt-2">Belum ada riwayat pengajuan</p>
    </div>
    @endif
    </div>
@endsection