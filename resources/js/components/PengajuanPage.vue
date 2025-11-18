<template>
  <div class="pengajuan-title">
    <h2>Kelola Pengajuan</h2>
  </div>
  
    <div class="card-barang">
    <div class="card-body">
    <div class="table-responsive">
        <table class="table-barang">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Siswa</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pengajuan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
    
        <tbody>
          <tr v-for="(p, index) in pengajuans.data" :key="p.id_pengajuan">
            <td>{{ pengajuans.from + index }}</td>
            <td>
              <strong>{{ p.user?.nama }}</strong><br>
              <small class="text-muted">NISN: {{ p.user?.nisn }}</small><br>
              <small class="text-muted">Kelas: {{ p.user?.kelas }}</small>
            </td>
            <td>{{ p.barang?.nama_barang || 'Barang tidak tersedia.' }}</td>
            <td>{{ p.jumlah }}</td>
            <td>{{ formatTanggal(p.tgl_pengajuan) }}</td>
            <td>
              <span v-if="p.status === 0" class="badge badge-warning">Pending</span>
              <span v-else-if="p.status === 1" class="badge badge-success">Approved</span>
              <span v-else class="badge badge-danger">Rejected</span>
            </td>
            <td>
  
            <div class="action-buttons">
              <button class="btn-outline info" @click="openDetail(p)">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                  stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              </button>

        <form v-if="p.status === 0" :action="`/admin/pengajuan/${p.id_pengajuan}/approve`" method="POST" style="display:inline;">
          <input type="hidden" name="_token" :value="csrf">
          <input type="hidden" name="_method" value="PATCH">
            <button type="submit" class="btn-outline success" @click="confirmAction($event, 'Setujui pengajuan ini?')">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" 
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12" />
              </svg>
            </button>
        </form>

        <form v-if="p.status === 0" :action="`/admin/pengajuan/${p.id_pengajuan}/reject`" method="POST" style="display:inline;">
          <input type="hidden" name="_token" :value="csrf">
          <input type="hidden" name="_method" value="PATCH">
            <button type="submit" class="btn-outline danger" @click="confirmAction($event, 'Tolak pengajuan ini?')">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" 
                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
            </button>
        </form>
            </div>
            
          </td>

              </tr>
            </tbody>
          </table>
        </div>

        <div v-if="pengajuans.links.length > 3" class="pagination-wrapper">
  <nav class="custom-pagination">
    <!-- Tombol Sebelumnya -->
    <a v-if="pengajuans.prev_page_url" :href="pengajuans.prev_page_url" class="page-link">&laquo;</a>
    <span v-else class="page-link disabled">&laquo;</span>

    <!-- Nomor Halaman -->
    <template v-for="(link, i) in pengajuans.links" :key="i">
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
    <a v-if="pengajuans.next_page_url" :href="pengajuans.next_page_url" class="page-link">&raquo;</a>
    <span v-else class="page-link disabled">&raquo;</span>
  </nav>

      </div>
    </div>

    <!-- === MODAL DETAIL === -->
    <div v-if="selected" class="modal-overlay" @click.self="selected = null">
      <div class="modal">
        <div class="modal-header">
          <h4>Detail Pengajuan #{{ selected.id_pengajuan }}</h4>
          <button class="close-btn" @click="selected = null">&times;</button>
        </div>
        <div class="modal-body">
          <table class="table table-borderless">
            <tr><td>ID Pengajuan</td><td>: {{ selected.id_pengajuan }}</td></tr>
            <tr><td>Nama Siswa</td><td>: {{ selected.user?.nama }} ({{ selected.user?.nisn }})</td></tr>
            <tr><td>Kelas</td><td>: {{ selected.user?.kelas }}</td></tr>
            <tr>
            <td>Barang</td>
            <td>
            <span v-if="selected.barang">{{ selected.barang.nama_barang }}</span>
            <span v-else class="text-danger fst-italic">Barang sudah dihapus</span>
            </td> 
            </tr>
            <tr><td>Jumlah</td><td>: {{ selected.jumlah }}</td></tr>
            <tr><td>Tanggal</td><td>: {{ formatTanggal(selected.tgl_pengajuan) }}</td></tr>
            <tr><td>Status</td>
              <td>
                <span v-if="selected.status === 0" class="badge badge-warning">Pending</span>
                <span v-else-if="selected.status === 1" class="badge badge-success">Approved</span>
                <span v-else class="badge badge-danger">Rejected</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  pengajuans: Object,
  csrf: String
})

const selected = ref(null)

function openDetail(p) {
  selected.value = p
}

function confirmAction(e, message) {
  if (!confirm(message)) e.preventDefault()
}

function formatTanggal(date) {
  return new Date(date).toLocaleString('id-ID')
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(104, 69, 69, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}
.modal {
  background: #ddecfd;
  padding: 1.5rem;
  border-radius: 10px;
  width: 600px;
  max-height: 80vh;
  overflow-y: auto;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0 1rem;
}
.close-btn {
  border: none;
  background: transparent;
  font-size: 2rem;
  font-weight: 500;
  cursor: pointer;
  margin-bottom: 10px;
}
</style>
