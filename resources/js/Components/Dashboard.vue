<template>
  <div class="dashboard-wrapper">
    <!-- Hero -->
    <section class="hero-section text-center">
      <h1 class="fw-bold display-6 mb-2">👋 Halo, {{ user.nama }}</h1>
      <p class="text-muted fs-5">Selamat datang di <strong>Sistem Inventaris</strong> Sekolah Anda.</p>
    </section>

    <!-- Statistik -->
    <section class="stats-section fade-in-up">
      <div class="row g-4">
        <div
          v-for="(card, index) in statsCards"
          :key="card.text"
          class="col-xl-3 col-md-6"
        >
          <div class="stats-card" :class="`bg-${index + 1}`">
            <div class="stats-icon">
              <i :class="card.icon"></i>
            </div>
            <div>
              <h3 class="fw-semibold mb-1">{{ card.value }}</h3>
              <p class="text-muted mb-0">{{ card.text }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Konten Utama -->
    <section class="main-content mt-5 fade-in-up">
      <div class="row g-4">
        <!-- Pengajuan -->
        <div class="col-lg-8">
          <div class="content-card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center border-0 pb-0">
              <h5 class="fw-bold mb-0">📋 Pengajuan Terbaru</h5>
              <a :href="routes.pengajuanIndex" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                Lihat Semua
              </a>
            </div>

            <div class="card-body px-0">
              <div v-if="pengajuan_terbaru.length > 0" class="table-responsive px-3">
                <table class="table align-middle table-borderless">
                  <thead>
                    <tr class="table-header-row">
                      <th>Barang</th>
                      <th>Jumlah</th>
                      <th>Status</th>
                      <th>Tanggal</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="p in pengajuan_terbaru"
                      :key="p.id"
                      class="hover-row"
                    >
                      <td class="fw-medium">{{ p.barang.nama_barang }}</td>
                      <td>{{ p.jumlah }}</td>
                      <td>
                        <span v-if="p.status === 0" class="badge status-badge pending">Pending</span>
                        <span v-else-if="p.status === 1" class="badge status-badge approved">Approved</span>
                        <span v-else class="badge status-badge rejected">Rejected</span>
                      </td>
                      <td>{{ formatDate(p.tgl_pengajuan) }}</td>
                      <td class="text-center">
                        <a
                          :href="routes.pengajuanShow.replace(':id', p.id_pengajuan)"
                          class="btn btn-sm btn-soft-dark rounded-pill px-3"
                        >
                          Detail
                        </a>

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <p v-else class="text-muted text-center my-4">Belum ada pengajuan yang dibuat.</p>
            </div>
          </div>
        </div>

        <!-- Barang -->
        <div class="col-lg-4">
          <div class="content-card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center border-0 pb-0">
              <h5 class="fw-bold mb-0">📦 Barang Tersedia</h5>
              <a :href="routes.pengajuanCreate" class="btn btn-sm btn-primary rounded-pill px-3">Ajukan</a>
            </div>
            <div class="card-body mt-3">
              <div v-if="barang_tersedia.length > 0" class="list-group">
                <div
                  v-for="b in barang_tersedia"
                  :key="b.id"
                  class="barang-card d-flex justify-content-between align-items-center"
                >
                  <div>
                    <h6 class="mb-0">{{ b.nama_barang }}</h6>
                    <small class="text-muted">Stok: {{ b.jumlah }}</small>
                  </div>
                  <span class="badge bg-success px-3 py-2 rounded-pill"></span>
                </div>
              </div>
              <p v-else class="text-muted text-center my-4">Tidak ada barang tersedia.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  props: {
    user: Object,
    stats: Object,
    pengajuan_terbaru: Array,
    barang_tersedia: Array,
    routes: Object,
  },
  computed: {
    statsCards() {
      return [
        { value: this.stats.total_pengajuan, text: "Total Pengajuan", icon: "bi bi-clipboard2-check" },
        { value: this.stats.pengajuan_pending, text: "Menunggu", icon: "bi bi-hourglass-split" },
        { value: this.stats.pengajuan_approved, text: "Disetujui", icon: "bi bi-check-circle" },
        { value: this.stats.barang_tersedia, text: "Barang Tersedia", icon: "bi bi-box-seam" },
      ];
    },
  },
  methods: {
    formatDate(dateStr) {
      const date = new Date(dateStr);
      return date.toLocaleDateString("id-ID");
    },
  },
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

.dashboard-wrapper {
  background: linear-gradient(to bottom, #a7d2ff, #d9ecff);
  min-height: 100vh;
  padding: 3rem 2rem;
  font-family: 'Poppins', sans-serif;
}

/* Hero */
.hero-section {
  margin-bottom: 3rem;
  animation: fadeIn 0.8s ease;
}

/* Statistik */
.stats-section {
  margin-bottom: 2rem;
}
.stats-card {
  display: flex;
  align-items: center;
  gap: 1.2rem;
  padding: 1.5rem;
  border-radius: 16px;
  color: white;
  box-shadow: 0 3px 15px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
  border: 1px solid rgba(240,240,240,0.6);
}
.stats-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}
.stats-icon {
  width: 60px;
  height: 60px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
}

/* 🌈 Warna Berbeda Tiap Box Statistik */
.bg-1 {
  background: #06b6d4;
}
.bg-2 {
  background: #f6d365;
}
.bg-3 {
  background: #3fb83fff;
}
.bg-4 {
  background: #667eea;
}

/* Card Konten */
.content-card {
  background: white;
  border-radius: 20px;
  padding: 1.5rem;
  transition: all 0.3s ease;
  border: 1px solid rgba(240,240,240,0.8);
}
.content-card:hover {
  transform: translateY(-4px);
}

/* Table */
.table-header-row th {
  font-size: 0.9rem;
  color: #6b7280;
  font-weight: 600;
  border-bottom: 2px solid #0e0d0dff;
}
.hover-row:hover {
  background: #f9fafb;
}

/* Barang Card */
.barang-card {
  background: #f8fafc;
  border-radius: 14px;
  padding: 0.9rem 1.1rem;
  margin-bottom: 0.6rem;
  transition: all 0.3s ease;
}
.barang-card:hover {
  background: #eef2ff;
  transform: translateY(-3px);
}

/* Tombol */
.btn-soft-dark {
  background: rgba(0,0,0,0.05);
  color: #111;
  border: none;
  transition: 0.3s;
}
.btn-soft-dark:hover {
  background: rgba(0,0,0,0.1);
}

/* Badge Status */
.status-badge {
  border-radius: 20px;
  padding: 6px 12px;
  font-size: 0.8rem;
  font-weight: 500;
}
.status-badge.pending { background: #fff3cd; color: #856404; }
.status-badge.approved { background: #d4edda; color: #155724; }
.status-badge.rejected { background: #f8d7da; color: #721c24; }

/* Animasi */
.fade-in-up {
  opacity: 0;
  transform: translateY(15px);
  animation: fadeUp 0.8s ease forwards;
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
