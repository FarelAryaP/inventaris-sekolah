<template>
  <div class="laporan-container">
    <div class="title-laporan mb-3">
      <h1>Laporan Peminjaman</h1>
    </div>

    <!-- Summary Cards -->
    <div class="info-card">
      <div class="column-card" style="background: rgba(89, 156, 233, 1);">
        <h4>{{ dataPeminjamans.length }}</h4>
        <p class="title-section">Total Peminjaman</p>
      </div>
      <div class="column-card" style="background: rgba(228, 236, 112, 1);">
        <h4>{{ sedangDipinjam }}</h4>
        <p class="title-section">Sedang Dipinjam</p>
      </div>
      <div class="column-card" style="background: rgba(128, 211, 112, 1);">
        <h4>{{ dikembalikan }}</h4>
        <p class="title-section">Dikembalikan</p>
      </div>
      <div class="column-card" style="background: rgba(255, 102, 102, 1);">
        <h4>{{ hilang }}</h4>
        <p class="title-section">Hilang</p>
      </div>
    </div>

    <!-- Table -->
      <div class="card-header">
        <h5 class="card-title mb-0">Detail Laporan Peminjaman</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table-name">
            <thead>
              <tr>
                <th>No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in dataPeminjamans" :key="item.id">
                <td>{{ index + 1 }}</td>
                <td>{{ item.pengajuan.user.nama }}</td>
                <td>{{ item.pengajuan.user.kelas }}</td>
                <td>{{ item.pengajuan.barang.nama_barang }}</td>
                <td>{{ item.pengajuan.jumlah }}</td>
                <td>{{ formatTanggal(item.tgl_mulai) }}</td>
                <td>{{ formatTanggal(item.tgl_selesai) }}</td>
                <td>
                  <span v-if="item.status === 0" class="badge bg-primary">Dipinjam</span>
                  <span v-else-if="item.status === 1" class="badge bg-success">Dikembalikan</span>
                  <span v-else class="badge bg-warning">Hilang</span>
                </td>
                <td>
                  <span v-if="isTerlambat(item)" class="text-danger">Terlambat</span>
                  <span v-else>-</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-footer">
        <small>Laporan dibuat pada {{ formatTanggal(new Date()) }}</small>
      </div>
  </div>
</template>

<script>
export default {
  name: "LaporanPeminjaman",
  props: {
    dataPeminjamans: {
      type: Array,
      required: true,
    },
  },
  computed: {
    sedangDipinjam() {
      return this.dataPeminjamans.filter(p => p.status === 0).length;
    },
    dikembalikan() {
      return this.dataPeminjamans.filter(p => p.status === 1).length;
    },
    hilang() {
      return this.dataPeminjamans.filter(p => p.status === 2).length;
    },
  },
  methods: {
    formatTanggal(tgl) {
      const date = new Date(tgl);
      return date.toLocaleDateString("id-ID");
    },
    isTerlambat(item) {
      if (item.status === 0) {
        const selesai = new Date(item.tgl_selesai);
        return selesai < new Date();
      }
      return false;
    },
  },
};
</script>