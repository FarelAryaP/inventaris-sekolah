<template>
  <div class="pengajuan-wrapper">
    <div class="container py-5">
      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3 fade-in-up">
        <a :href="dashboardUrl" class="btn btn-outline-dark back-btn px-4 py-2 d-flex align-items-center">
          <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
        <h1 class="fw-bold text-dark mb-0">📋 Daftar Pengajuan Anda</h1>
        <a :href="createUrl" class="btn btn-gradient px-4 py-2">
          <i class="bi bi-plus-circle me-2"></i> Ajukan Barang
        </a>
      </div>

      <!-- Daftar Pengajuan -->
      <div v-if="pengajuans.length > 0" class="row g-4 fade-in-up">
        <div
          v-for="pengajuan in pengajuans"
          :key="pengajuan.id"
          class="col-12 col-md-6 col-lg-4"
        >
          <div class="card pengajuan-card shadow-sm border-0 h-100">
            <div class="card-body d-flex flex-column">
              <div class="mb-3">
                <h5 class="fw-bold text-dark mb-1">{{ pengajuan.barang.nama_barang }}</h5>
                <p class="text-muted small mb-1"><i class="bi bi-box"></i> Jumlah: {{ pengajuan.jumlah }}</p>
                <p class="text-muted small mb-1"><i class="bi bi-calendar"></i> {{ formatDate(pengajuan.tgl_pengajuan) }}</p>
                <p class="text-muted small mb-2"><i class="bi bi-clock"></i> {{ formatDate(pengajuan.tgl_mulai) }} - {{ formatDate(pengajuan.tgl_selesai) }}</p>
              </div>

              <!-- Status -->
              <span
                class="badge status-badge mb-3 align-self-start"
                :class="{
                  'pending': pengajuan.status === 0,
                  'approved': pengajuan.status === 1,
                  'rejected': pengajuan.status === 2
                }"
              >
                {{ statusLabel(pengajuan.status) }}
              </span>

              <!-- Tombol Detail -->
              <a :href="`/pengajuan/${pengajuan.id_pengajuan}`" class="btn btn-sm btn-dark rounded-pill px-3">
    Detail
</a>

            </div>
          </div>
        </div>
      </div>

      <!-- Jika Kosong -->
      <div v-else class="text-center py-5 fade-in-up">
        <i class="bi bi-inbox text-secondary fs-1"></i>
        <p class="text-muted mt-3 fs-5">Belum ada pengajuan barang</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
  pengajuans: { type: Array, required: true },
  createUrl: { type: String, required: true },
  dashboardUrl: { type: String, required: true },
  prevUrl: { type: String, default: null },
  nextUrl: { type: String, default: null },
  currentPage: { type: [String, Number], default: 1 },
  lastPage: { type: [String, Number], default: 1 },
});

const formatDate = (dateStr) => {
  if (!dateStr) return "-";
  return new Date(dateStr).toLocaleDateString("id-ID", {
    day: "2-digit",
    month: "short",
    year: "numeric",
  });
};

const statusLabel = (status) => {
  switch (status) {
    case 0:
      return "Menunggu Persetujuan";
    case 1:
      return "Disetujui";
    case 2:
      return "Ditolak";
    default:
      return "Tidak Diketahui";
  }
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

/* ==========================
   Latar & Layout
========================== */
.pengajuan-wrapper {
  background: linear-gradient(to bottom, #a7d2ff, #d9ecff);
  min-height: 100vh;
  padding: 3rem 2rem;
  font-family: 'Poppins', sans-serif;
  animation: fadeIn 0.8s ease;
}

/* ==========================
   Header
========================== */
h1 {
  font-size: 2rem;
  letter-spacing: 0.5px;
}

.back-btn {
  border-radius: 50px;
  font-weight: 500;
  transition: all 0.3s;
}
.back-btn:hover {
  background: #FFFD93;
  color: #120e0eff;
  transform: translateX(-3px);
}

/* ==========================
   Card Pengajuan
========================== */
.pengajuan-card {
  background: white;
  border-radius: 20px;
  padding: 1.3rem;
  border: 1px solid rgba(240,240,240,0.8);
  transition: all 0.3s ease;
}
.pengajuan-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

/* ==========================
   Badge Status
========================== */
.status-badge {
  border-radius: 20px;
  padding: 6px 12px;
  font-size: 0.8rem;
  font-weight: 500;
}
.status-badge.pending {
  background: #fff3cd;
  color: #856404;
}
.status-badge.approved {
  background: #d4edda;
  color: #155724;
}
.status-badge.rejected {
  background: #f8d7da;
  color: #721c24;
}

/* ==========================
   Tombol
========================== */
.btn-gradient {
  background: #FFFD93;
  color: #120e0eff;
  font-weight: 600;
  border: none;
  border-radius: 50px;
  transition: all 0.3s ease-in-out;
}
.btn-gradient:hover {
  background: #FFFD93;
  transform: scale(1.05);
}

/* ==========================
   Pagination
========================== */
.modern-pagination .page-item .page-link {
  border: none;
  border-radius: 50px;
  margin: 0 5px;
  color: #198754;
  font-weight: 500;
  transition: all 0.3s ease;
}
.modern-pagination .page-item .page-link:hover {
  background-color: #198754;
  color: #fff;
}
.modern-pagination .page-item.disabled .page-link {
  color: #aaa;
  background-color: #f8f9fa;
}

/* ==========================
   Animasi
========================== */
.fade-in-up {
  opacity: 0;
  transform: translateY(15px);
  animation: fadeUp 0.8s ease forwards;
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>
