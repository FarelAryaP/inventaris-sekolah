<template>
  <div class="peminjaman-title">
      <h3>Kelola Peminjaman</h3>
      
      <a :href="laporanUrl" class="btn-info">
        <i class="bi bi-file-earmark-text"></i> Laporan
      </a>
  </div>

    <!-- Statistik -->
    <div class="stats-grid">
      <div class="stat-card bg-primary">
        <h4>{{ countByStatus(0) }}</h4>
        <p>Sedang Dipinjam</p>
      </div>
      <div class="stat-card bg-success">
        <h4>{{ countByStatus(1) }}</h4>
        <p>Sudah Dikembalikan</p>
      </div>
      <div class="stat-card bg-warning">
        <h4>{{ countByStatus(2) }}</h4>
        <p>Hilang</p>
      </div>
      <div class="stat-card bg-info">
        <h4>{{ peminjamans.length }}</h4>
        <p>Total Peminjaman</p>
      </div>
    </div>

    <!-- Tabel -->
  <div class="card-peminjaman">
  <div class="card-body">
  <div class="table-responsive">
    <table class="table-peminjaman">
    <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Siswa</th>
              <th>Barang</th>
              <th>Jumlah</th>
              <th>Periode</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="peminjaman in peminjamans" :key="peminjaman.id_peminjaman">
              <td>{{ peminjaman.id_peminjaman }}</td>
              <td>
                <strong>{{ peminjaman.pengajuan.user.nama }}</strong><br />
                <small class="muted">NISN: {{ peminjaman.pengajuan.user.nisn }}</small><br />
                <small class="muted">Kelas: {{ peminjaman.pengajuan.user.kelas }}</small>
              </td>
              <td>{{ peminjaman.pengajuan.barang.nama_barang }}</td>
              <td>{{ peminjaman.pengajuan.jumlah }}</td>
              <td>
                {{ formatDate(peminjaman.tgl_mulai) }} - {{ formatDate(peminjaman.tgl_selesai) }}
                <br v-if="isLate(peminjaman)" />
                <small v-if="isLate(peminjaman)" class="text-danger">⚠ Terlambat</small>
              </td>
              <td>
                <span v-if="peminjaman.status === 0" class="badge bg-primary">Sedang Dipinjam</span>
                <span v-else-if="peminjaman.status === 1" class="badge bg-success">Dikembalikan</span>
                <span v-else class="badge bg-warning">Hilang</span>
              </td>
              <td>
                <div class="action-buttons">
                  <!-- Ganti dari href jadi trigger modal -->
                  <button class="btn-outline-info" title="Lihat Detail" @click="openModal(peminjaman)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor"
                      stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                      <circle cx="12" cy="12" r="3" />
                    </svg>
                  </button>

                  <template v-if="peminjaman.status === 0">
                    <form :action="`/admin/peminjaman/${peminjaman.id_peminjaman}/kembalikan`" method="POST"
                      @submit.prevent="confirmAction($event, 'Konfirmasi pengembalian barang?')">
                      <input type="hidden" name="_method" value="PATCH" />
                      <input type="hidden" name="_token" :value="csrf" />
                      <button type="submit" class="btn-outline-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                          stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          viewBox="0 0 24 24">
                          <polyline points="23 4 23 10 17 10" />
                          <polyline points="1 20 1 14 7 14" />
                          <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10" />
                          <path d="M20.49 15a9 9 0 0 1-14.85 3.36L1 14" />
                        </svg>
                      </button>
                    </form>

                    <form :action="`/admin/peminjaman/${peminjaman.id_peminjaman}/hilang`" method="POST"
                      @submit.prevent="confirmAction($event, 'Konfirmasi barang hilang?')">
                      <input type="hidden" name="_method" value="PATCH" />
                      <input type="hidden" name="_token" :value="csrf" />
                      <button type="submit" class="btn-outline-warning">
                        ⚠
                      </button>
                    </form>
                  </template>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

      <!-- Pagination -->
      <!-- Pagination -->
<div v-if="peminjamansData.links && peminjamansData.links.length > 3" class="pagination-wrapper">
  <nav class="custom-pagination">
    <!-- Tombol Sebelumnya -->
    <a v-if="peminjamansData.prev_page_url" :href="peminjamansData.prev_page_url" class="page-link">&laquo;</a>
    <span v-else class="page-link disabled">&laquo;</span>

    <!-- Nomor Halaman -->
    <template v-for="(link, i) in peminjamansData.links" :key="i">
      <a
        v-if="link.url && !link.label.includes('laquo') && !link.label.includes('raquo')"
        :href="link.url"
        class="page-link"
        :class="{ active: link.active }"
        v-html="link.label"
      ></a>
      <span
        v-else-if="!link.url && !link.label.includes('laquo') && !link.label.includes('raquo')"
        class="page-link disabled"
        v-html="link.label"
      ></span>
    </template>

    <!-- Tombol Berikutnya -->
    <a v-if="peminjamansData.next_page_url" :href="peminjamansData.next_page_url" class="page-link">&raquo;</a>
    <span v-else class="page-link disabled">&raquo;</span>
  </nav>
</div>

    </div>

    <!-- Modal Detail -->
    <div v-if="showModal" class="modal-backdrop" @click.self="closeModal">
      <div class="modal-box">
        <div class="modal-header">
          <h4>Detail Peminjaman #{{ detail.id_peminjaman }}</h4>
          <button class="close-btn" @click="closeModal">×</button>
        </div>
        <div class="modal-body">
          <div class="grid-2">
            <div>
              <h5>Data Siswa</h5>
              <p><strong>Nama:</strong> {{ detail.pengajuan.user.nama }}</p>
              <p><strong>NISN:</strong> {{ detail.pengajuan.user.nisn }}</p>
              <p><strong>Kelas:</strong> {{ detail.pengajuan.user.kelas }}</p>
            </div>
            <div>
              <h5>Data Barang</h5>
              <p><strong>Nama Barang:</strong> {{ detail.pengajuan.barang.nama_barang }}</p>
              <p><strong>Jumlah:</strong> {{ detail.pengajuan.jumlah }}</p>
              <p><strong>Keterangan:</strong> {{ detail.pengajuan.barang.keterangan || '-' }}</p>
            </div>
          </div>

          <hr>

          <h5>Informasi Peminjaman</h5>
          <p><strong>Tanggal Mulai:</strong> {{ formatDate(detail.tgl_mulai) }}</p>
          <p><strong>Tanggal Selesai:</strong> {{ formatDate(detail.tgl_selesai) }}</p>
          <p><strong>Status:</strong>
            <span v-if="detail.status === 0" class="badge bg-primary">Sedang Dipinjam</span>
            <span v-else-if="detail.status === 1" class="badge bg-success">Dikembalikan</span>
            <span v-else class="badge bg-warning">Hilang</span>
          </p>
        </div>
      </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// Props dari Blade
const props = defineProps({
  peminjamansJson: String,
  laporanUrl: String,
  csrf: String
})

// Parsing JSON (ambil seluruh struktur pagination)
const peminjamansData = computed(() => {
  try {
    return JSON.parse(props.peminjamansJson || '{}')
  } catch (e) {
    console.error('Gagal parse JSON dari Blade:', e)
    return {}
  }
})

// Ambil hanya array datanya
const peminjamans = computed(() => {
  const data = peminjamansData.value.data || []
  return data.slice().reverse() 
})


// State modal
const showModal = ref(false)
const detail = ref(null)

const openModal = (item) => {
  detail.value = item
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  detail.value = null
}

// Fungsi bantu
const countByStatus = (status) =>
  peminjamans.value.filter((p) => p.status === status).length

const formatDate = (date) =>
  new Date(date).toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  })

const isLate = (peminjaman) =>
  peminjaman.status === 0 &&
  new Date(peminjaman.tgl_selesai) < new Date()

const confirmAction = (e, msg) => {
  if (confirm(msg)) e.target.submit()
}
</script>


<style scoped src="../../css/peminjaman.css"></style>

