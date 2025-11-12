<template>
  <div class="dashboard-page">
    <h3 class="page-title">
      Selamat Datang, {{ admin.nama }}!
    </h3>

    <!-- Statistik -->
    <div class="stat-grid">
      <div class="stat-card stat-primary">
        <div class="stat-content">
          <div>
            <h4>{{ stats.total_barang }}</h4>
            <p>Total Barang</p>
          </div>
          <div class="icon-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none"
              stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
              stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
              <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
              <line x1="12" y1="22.08" x2="12" y2="12" />
            </svg>
          </div>
        </div>
      </div>

      <div class="stat-card stat-success">
        <div class="stat-content">
          <div>
            <h4>{{ stats.total_siswa }}</h4>
            <p>Total Siswa</p>
          </div>
          <div class="icon-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none"
              stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
              stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="7" r="4" />
              <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
            </svg>
          </div>
        </div>
      </div>

      <div class="stat-card stat-warning">
        <div class="stat-content">
          <div>
            <h4>{{ stats.pengajuan_pending }}</h4>
            <p>Pengajuan Pending</p>
          </div>
          <div class="icon-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="none"
              stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
              stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <polyline points="12 6 12 12 16 14" />
            </svg>
          </div>
        </div>
      </div>
    </div>
        <!-- Super Admin-->
        <div v-if="isSuperAdmin" class="super-admin-section" style="margin-top: 2rem;">
      <h3 class="page-title">Panel Super Admin</h3>

      <div class="stat-grid">
        <div class="stat-card stat-primary">
          <div class="stat-content">
            <div>
              <h4>Kelola Siswa</h4>
              <a href="/admin/users" class="btn-outline-small">Lihat</a>
            </div>
            <div class="icon-box">
              <i class="bi bi-people" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>

        <div class="stat-card stat-success">
          <div class="stat-content">
            <div>
              <h4>Kelola Admin</h4>
              <a href="/admin/admins" class="btn-outline-small">Lihat</a>
            </div>
            <div class="icon-box">
              <i class="bi bi-person-gear" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>

        <div class="stat-card stat-warning">
          <div class="stat-content">
            <div>
              <h4>Log Aktivitas</h4>
              <a href="/admin/logs" class="btn-outline-small">Lihat</a>
            </div>
            <div class="icon-box">
              <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pengajuan Terbaru -->
    <div class="main-content">
      <div class="card">
        <div class="card-header">
          <h5>Pengajuan Terbaru</h5>
        </div>
        <div class="card-body">
          <template v-if="pengajuanTerbaru.length > 0">
            <div class="table-wrapper">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Siswa</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="p in pengajuanTerbaru" :key="p.id">
                    <td>{{ p.user.nama }}</td>
                    <td>{{ p.barang.nama_barang }}</td>
                    <td>{{ p.jumlah }}</td>
                    <td>{{ formatTanggal(p.tgl_pengajuan) }}</td>
                    <td>
                      <a :href="`/admin/pengajuan/${p.id_pengajuan}`" class="btn-outline-small">Detail</a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="text-center">
              <a href="/admin/pengajuan" class="btn-outline">Lihat Semua</a>
            </div>
          </template>
          <p v-else class="text-muted">Tidak ada pengajuan pending</p>
        </div>
      </div>

      <!-- Stok Rendah -->
      <div class="card">
        <div class="card-header">
          <h5>Stok Rendah</h5>
        </div>
        <div class="card-body">
          <template v-if="barangStokRendah.length > 0">
            <div v-for="b in barangStokRendah" :key="b.id" class="stok-item">
              <div>
                <strong>{{ b.nama_barang }}</strong><br>
                <small>Stok: {{ b.jumlah }}</small>
              </div>
              <span class="badge-warning">Rendah</span>
            </div>
          </template>
          <p v-else class="text-muted">Semua barang stoknya cukup</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  admin: Object,
  stats: Object,
  pengajuanTerbaru: Array,
  barangStokRendah: Array
})

const formatTanggal = (tgl) => {
  const d = new Date(tgl)
  return d.toLocaleDateString('id-ID')
}
</script>

<style scoped>
/* bisa pakai css dashboard-admin.css */
</style>
