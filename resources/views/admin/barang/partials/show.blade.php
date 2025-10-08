<div class="p-2">
    <table class="table table-borderless">
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
                <span class="badge {{ $barang->jumlah < 5 ? 'bg-warning' : 'bg-success' }}">
                    {{ $barang->jumlah }}
                </span>
            </td>
        </tr>
        <tr>
            <td class="fw-bold">Keterangan</td>
            <td>: {{ $barang->keterangan ?: 'Tidak ada keterangan' }}</td>
        </tr>
    </table>

    <div class="text-end">
        <button class="btn-secondary close-modal">Tutup</button>
    </div>
</div>
