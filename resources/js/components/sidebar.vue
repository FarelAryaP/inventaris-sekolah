<template>
  <nav class="sidebar">
    <div class="sidebar-container">
      <a class="brand" href="/dashboard">Inventaris Sekolah</a>
      <ul class="menu">
        <li><a :href="dashboardUrl">Dashboard</a></li>
        <li><a :href="barangUrl">Barang</a></li>
        <li><a :href="pengajuanUrl">Pengajuan</a></li>
        <li><a :href="peminjamanUrl">Peminjaman</a></li>
        <li><a :href="laporanUrl">Laporan</a></li>
      </ul>
      <div class="user-dropdown" ref="dropdownRef">
        <a href="#" class="user-name" @click.prevent="toggleDropdown">
          {{ userName }}
        </a>

        <transition name="fade-slide">
        <div v-if="dropdownOpen" class="dropdown-menu">
          <button class="logout-btn" @click="logout">Logout</button>
        </div>
        </transition>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { computed, ref, onMounted, onBeforeUnmount } from 'vue'

const props = defineProps({
  dashboardUrl: String,
  barangUrl: String,
  pengajuanUrl: String,
  peminjamanUrl: String,
  laporanUrl: String,
  user: Object
})

const dropdownOpen = ref(false)
const dropdownRef = ref(null)

const userName = computed(() => props.user?.username || 'Guest')

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

function logout() {
  document.getElementById('logout-form').submit()
}

function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    dropdownOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>


