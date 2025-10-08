<form action="{{ route('admin.barang.store') }}" method="POST" class="form-barang">
    @csrf

    <div class="form-group">
        <label for="nama_barang">Nama Barang <span class="required">*</span></label>
        <input type="text" id="nama_barang" name="nama_barang" required>
    </div>

    <div class="form-group">
        <label for="jumlah">Jumlah <span class="required">*</span></label>
        <input type="number" id="jumlah" name="jumlah" min="0" required>
    </div>

    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
            </svg>
            Simpan
        </button>
        <button type="button" class="btn-secondary">Batal</button>
    </div>
</form>
