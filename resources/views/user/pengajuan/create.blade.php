@extends('layouts.app')

@section('title', 'Buat Pengajuan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('user.pengajuan.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Buat Pengajuan Peminjaman</h1>
        <p class="text-gray-600">Isi form berikut untuk mengajukan peminjaman barang</p>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form method="POST" action="{{ route('user.pengajuan.store') }}">
            @csrf

            <!-- Pilih Barang -->
            <div class="mb-6">
                <label for="id_barang" class="label">Pilih Barang <span class="text-red-500">*</span></label>
                <select name="id_barang" id="id_barang" class="input-field @error('id_barang') input-error @enderror" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}>
                            {{ $barang->nama_barang }} (Stok: {{ $barang->jumlah }})
                        </option>
                    @endforeach
                </select>
                @error('id_barang')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah -->
            <div class="mb-6">
                <label for="jumlah" class="label">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', 1) }}" min="1"
                       class="input-field @error('jumlah') input-error @enderror" required>
                @error('jumlah')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Mulai -->
            <div class="mb-6">
                <label for="tgl_mulai" class="label">Tanggal Mulai Pinjam <span class="text-red-500">*</span></label>
                <input type="date" name="tgl_mulai" id="tgl_mulai" value="{{ old('tgl_mulai', date('Y-m-d')) }}" 
                       min="{{ date('Y-m-d') }}"
                       class="input-field @error('tgl_mulai') input-error @enderror" required>
                @error('tgl_mulai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Selesai -->
            <div class="mb-6">
                <label for="tgl_selesai" class="label">Tanggal Selesai Pinjam <span class="text-red-500">*</span></label>
                <input type="date" name="tgl_selesai" id="tgl_selesai" value="{{ old('tgl_selesai') }}"
                       class="input-field @error('tgl_selesai') input-error @enderror" required>
                @error('tgl_selesai')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Info -->
            <div class="alert-info mb-6">
                <div class="flex">
                    <svg class="h-5 w-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm">
                        <p class="font-medium">Informasi:</p>
                        <ul class="list-disc list-inside mt-1 text-blue-700">
                            <li>Pengajuan akan diproses oleh admin</li>
                            <li>Pastikan stok barang mencukupi</li>
                            <li>Tanggal mulai minimal hari ini</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('user.pengajuan.index') }}" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto update min date for tgl_selesai
    document.getElementById('tgl_mulai').addEventListener('change', function() {
        document.getElementById('tgl_selesai').min = this.value;
    });
</script>
@endsection