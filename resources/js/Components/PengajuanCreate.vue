<template>
  <div class="form-page d-flex justify-content-center align-items-center">
    <div class="card border-0 shadow-lg rounded-4">
      <div class="card-body p-4">
        <form :action="routes.store" method="POST">
          <input type="hidden" name="_token" :value="csrf">

          <!-- Judul Tengah -->
          <div class="text-center mb-4">
            <h1 class="fw-bold text-dark mb-1">Peminjaman Barang</h1>
          </div>

          <!-- Pilih Barang + Jumlah -->
          <div class="mb-3">
            <label class="form-label fw-semibold">Pilih Barang & Jumlah</label>
            <div class="d-flex gap-2 align-items-center">
              <select
                id="id_barang"
                name="id_barang"
                class="form-select flex-grow-1"
                v-model="selectedBarang"
                @change="updateMaxJumlah"
                required
              >
                <option value="">-- Pilih Barang --</option>
                <option
                  v-for="barang in barangs"
                  :key="barang.id_barang"
                  :value="barang.id_barang"
                >
                  {{ barang.nama_barang }} 
                </option>
              </select>
              <input
                type="number"
                id="jumlah"
                name="jumlah"
                class="form-control jumlah-input text-center"
                v-model="jumlah"
                :max="maxJumlah"
                min="1"
                required
              />
            </div>
            <small class="text-muted d-block mt-1">Maksimal: {{ maxJumlah || '-' }}</small>
          </div>

          <!-- Tanggal Mulai -->
          <div class="mb-3">
            <label for="tgl_mulai" class="form-label fw-semibold">Tanggal Mulai</label>
            <input
              type="date"
              id="tgl_mulai"
              name="tgl_mulai"
              class="form-control"
              v-model="tglMulai"
              :min="today"
              @change="setTanggalSelesaiMin"
              required
            />
          </div>

          <!-- Tanggal Selesai -->
          <div class="mb-4">
            <label for="tgl_selesai" class="form-label fw-semibold">Tanggal Selesai</label>
            <input
              type="date"
              id="tgl_selesai"
              name="tgl_selesai"
              class="form-control"
              v-model="tglSelesai"
              :min="tglSelesaiMin"
              required
            />
          </div>

          <!-- Tombol (tengah) -->
          <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-success px-4 d-flex align-items-center gap-2">
              <i class="bi bi-send"></i> Ajukan
            </button>
            <a :href="routes.index" class="btn btn-outline-secondary px-4">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
  barangs: Array,
  routes: Object,
  csrf: String
})

const selectedBarang = ref('')
const jumlah = ref(1)
const maxJumlah = ref(null)
const tglMulai = ref('')
const tglSelesai = ref('')
const tglSelesaiMin = ref('')
const today = new Date().toISOString().split('T')[0]

const updateMaxJumlah = () => {
  const barang = props.barangs.find(b => b.id_barang == selectedBarang.value)
  maxJumlah.value = barang ? barang.jumlah : null
}

const setTanggalSelesaiMin = () => {
  if (tglMulai.value) {
    const nextDay = new Date(tglMulai.value)
    nextDay.setDate(nextDay.getDate() + 1)
    tglSelesaiMin.value = nextDay.toISOString().split('T')[0]
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

/* Gunakan font Poppins untuk seluruh halaman */
* {
  font-family: 'Poppins', sans-serif !important;
}

/* Fullscreen Background */
.form-page {
  height: 100vh;
  width: 100vw;
  background: linear-gradient(to bottom right, #b3d9ff, #d8ebff, #a2c8ff);
  background-attachment: fixed;
  overflow: hidden;
}

/* Card Style */
.card {
  width: 100%;
  max-width: 700px;
  border-radius: 1.25rem;
  transition: all 0.3s ease;
  background: #ffffffee;
}
.card:hover {
  transform: translateY(-3px);
  box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
}

/* Input Jumlah */
.jumlah-input {
  width: 90px;
  border-radius: 8px;
}

/* Button Style */
.btn-success {
  background: #549deaff;
  border: none;
}
.btn-success:hover {
  background: #174fb8ff;
}
</style>
