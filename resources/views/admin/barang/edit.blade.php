@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Edit Barang</h1>
            <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.barang.update', $barang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang *</label>
                <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                       id="nama_barang" name="nama_barang" 
                       value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                @error('nama_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah *</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                       id="jumlah" name="jumlah" 
                       value="{{ old('jumlah', $barang->jumlah) }}" min="0" required>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $barang->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Update
                </button>
                <a href="{{ route('admin.barang.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection