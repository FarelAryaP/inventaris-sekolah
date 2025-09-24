@extends('layouts.user')

@section('title', 'Ajukan Barang')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Ajukan Peminjaman Barang</h1>
            <a href="{{ route('user.pengajuan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('user.pengajuan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_barang" class="form-label">Pilih Barang *</label>
                <select class="form-select @error('id_barang') is-invalid @enderror" 
                        id="id_barang" name="id_barang" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                    <option value="{{ $barang->id_barang }}" 
                            {{ old('id_barang') == $barang->id_barang ? 'selected' : '' }}
                            data-stok="{{ $barang->jumlah }}">
                        {{ $barang->nama_barang }} (Stok: {{ $barang->jumlah }})
                    </option>
                    @endforeach
                </select>
                @error('id_barang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah *</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                       id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required>
                <div class="form-text">Masukkan jumlah barang yang ingin dipinjam</div>
                @error('jumlah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tgl_mulai" class="form-label">Tanggal Mulai *</label>
                <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror" 
                       id="tgl_mulai" name="tgl_mulai" value="{{ old('tgl_mulai') }}" 
                       min="{{ date('Y-m-d') }}" required>
                @error('tgl_mulai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tgl_selesai" class="form-label">Tanggal Selesai *</label>
                <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror" 
                       id="tgl_selesai" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required>
                @error('tgl_selesai')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-send"></i> Ajukan
                </button>
                <a href="{{ route('user.pengajuan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('id_barang').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stok = selectedOption.dataset.stok;
    const jumlahInput = document.getElementById('jumlah');
    
    if (stok) {
        jumlahInput.max = stok;
        jumlahInput.placeholder = `Maksimal ${stok}`;
    }
});

document.getElementById('tgl_mulai').addEventListener('change', function() {
    const tglMulai = new Date(this.value);
    const tglSelesai = document.getElementById('tgl_selesai');
    
    // Set tanggal minimum untuk tgl_selesai
    tglMulai.setDate(tglMulai.getDate() + 1);
    tglSelesai.min = tglMulai.toISOString().split('T')[0];
});
</script>
@endpush