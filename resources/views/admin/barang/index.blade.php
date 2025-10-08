@extends('layouts.admin')

@section('title', 'Kelola Barang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Kelola Barang</h1>
            <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Barang
            </a>
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
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr>
                        <td>{{ $barang->id_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>
                            <span class="badge {{ $barang->jumlah < 5 ? 'bg-warning' : 'bg-success' }}">
                                {{ $barang->jumlah }}
                            </span>
                        </td>
                        <td>{{ Str::limit($barang->keterangan, 50) ?: '-' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.barang.show', $barang) }}" 
                                   class="btn btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.barang.edit', $barang) }}" 
                                   class="btn btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.barang.destroy', $barang) }}" 
                                      method="POST" class="d-inline" 
                                      onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
            <div class="d-flex justify-content-center">
            {{ $barangs->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection