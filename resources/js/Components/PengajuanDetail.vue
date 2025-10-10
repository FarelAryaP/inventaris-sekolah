<template>
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="h3">Detail Pengajuan #{{ pengajuan.id_pengajuan }}</h1>
      <a :href="routes.index" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row">
          <!-- Info utama -->
          <div class="col-md-8">
            <table class="table table-borderless">
              <tr>
                <td class="fw-bold">ID Pengajuan</td>
                <td>: {{ pengajuan.id_pengajuan }}</td>
              </tr>
              <tr>
                <td class="fw-bold">Barang</td>
                <td>: {{ pengajuan.barang.nama_barang }}</td>
              </tr>
              <tr>
                <td class="fw-bold">Jumlah</td>
                <td>: {{ pengajuan.jumlah }}</td>
              </tr>
              <tr>
                <td class="fw-bold">Tanggal Pengajuan</td>
                <td>: {{ formatDate(pengajuan.tgl_pengajuan, true) }}</td>
              </tr>
              <tr>
                <td class="fw-bold">Periode Peminjaman</td>
                <td>: {{ formatDate(pengajuan.tgl_mulai) }} s/d {{ formatDate(pengajuan.tgl_selesai) }}</td>
              </tr>
              <tr>
                <td class="fw-bold">Status</td>
                <td>
                  <span v-if="pengajuan.status == 0" class="badge bg-warning fs-6">Menunggu Persetujuan</span>
                  <span v-else-if="pengajuan.status == 1" class="badge bg-success fs-6">Disetujui</span>
                  <span v-else class="badge bg-danger fs-6">Ditolak</span>
                </td>
              </tr>
              <tr v-if="pengajuan.admin">
                <td class="fw-bold">Diproses oleh</td>
                <td>: {{ pengajuan.admin.nama }}</td>
              </tr>
            </table>
          </div>

          <!-- Timeline -->
          <div class="col-md-4">
            <div class="card bg-light mb-3">
              <div class="card-body">
                <h6 class="card-title">Status Timeline</h6>
                <div class="timeline">
                  <div class="timeline-item active">
                    <i class="bi bi-check-circle text-success"></i>
                    <span>Pengajuan dibuat</span>
                    <small class="text-muted d-block">{{ formatDate(pengajuan.tgl_pengajuan, true) }}</small>
                  </div>
                  <div class="timeline-item" :class="{ active: pengajuan.status !== 0 }">
                    <i v-if="pengajuan.status == 1" class="bi bi-check-circle text-success"></i>
                    <i v-else-if="pengajuan.status == 2" class="bi bi-x-circle text-danger"></i>
                    <i v-else class="bi bi-clock text-warning"></i>
                    <span>
                      {{ pengajuan.status == 1 ? 'Disetujui' : pengajuan.status == 2 ? 'Ditolak' : 'Menunggu persetujuan' }}
                    </span>
                    <small v-if="pengajuan.updated_at != pengajuan.created_at" class="text-muted d-block">
                      {{ formatDate(pengajuan.updated_at, true) }}
                    </small>
                  </div>

                  <div
                    v-if="pengajuan.status == 1 && pengajuan.detailPeminjaman"
                    class="timeline-item"
                    :class="{ active: pengajuan.detailPeminjaman.status == 1 }"
                  >
                    <i v-if="pengajuan.detailPeminjaman.status == 1" class="bi bi-check-circle text-success"></i>
                    <i v-else-if="pengajuan.detailPeminjaman.status == 2" class="bi bi-exclamation-triangle text-warning"></i>
                    <i v-else class="bi bi-arrow-repeat text-primary"></i>
                    <span>
                      {{
                        pengajuan.detailPeminjaman.status == 1
                          ? 'Dikembalikan'
                          : pengajuan.detailPeminjaman.status == 2
                          ? 'Hilang'
                          : 'Sedang dipinjam'
                      }}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="pengajuan.status == 1 && pengajuan.detailPeminjaman" class="card">
              <div class="card-body">
                <h6 class="card-title">Info Peminjaman</h6>
                <p><strong>Status:</strong> {{ pengajuan.detailPeminjaman.status_text }}</p>
                <p><strong>Mulai:</strong> {{ formatDate(pengajuan.detailPeminjaman.tgl_mulai) }}</p>
                <p><strong>Selesai:</strong> {{ formatDate(pengajuan.detailPeminjaman.tgl_selesai) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    pengajuan: Object,
    routes: Object
  },
  methods: {
    formatDate(date, withTime = false) {
      if (!date) return '-';
      const d = new Date(date);
      return withTime
        ? d.toLocaleString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })
        : d.toLocaleDateString('id-ID');
    }
  }
};
</script>

<style scoped>
.timeline {
  position: relative;
  padding-left: 30px;
}
.timeline::before {
  content: '';
  position: absolute;
  left: 15px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: #dee2e6;
}
.timeline-item {
  position: relative;
  margin-bottom: 20px;
}
.timeline-item i {
  position: absolute;
  left: -23px;
  top: 2px;
  background: white;
  padding: 2px;
}
.timeline-item.active i {
  color: var(--bs-success) !important;
}
</style>
