@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.barang.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Edit Barang</h1>
        <p class="text-gray-600">Perbarui data barang</p>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('admin.barang.update', $barang) }}">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="nama_barang" class="label">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" id="nama_barang" 
                       value="{{ old('nama_barang', $barang->nama_barang) }}"
                       class="input-field {{ $errors->has('nama_barang') ? 'input-error' : '' }}" required>
                @error('nama_barang')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="jumlah" class="label">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" id="jumlah" 
                       value="{{ old('jumlah', $barang->jumlah) }}" min="0"
                       class="input-field {{ $errors->has('jumlah') ? 'input-error' : '' }}" required>
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="keterangan" class="label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                          class="input-field {{ $errors->has('keterangan') ? 'input-error' : '' }}">{{ old('keterangan', $barang->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.barang.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection