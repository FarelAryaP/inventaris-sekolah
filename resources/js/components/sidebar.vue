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
        <!-- fitur super admin-->
          <li v-if="isSuperAdmin" 
          @click="toggleSuperAdmin" 
          class="dropdown-toggle">
  <i class="bi bi-shield-lock"></i> Super Admin
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor"
    stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
    :class="{ 'rotate': superAdminOpen }">
    <polyline points="6 9 12 15 18 9" />
  </svg>
</li>
<ul v-if="isSuperAdmin" 
  v-show="superAdminOpen" 
  class="submenu">
  <li>
    <a href="/admin/users">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
      </svg> Kelola Siswa
    </a>
  </li>
  <li>
    <a href="/admin/admins">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-gear" viewBox="0 0 16 16">
      <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1zm3.63-4.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382zM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0"/>
      </svg> Kelola Admin
    </a>
  </li>
</ul>
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

const superAdminOpen = ref(false)
function toggleSuperAdmin() {
  superAdminOpen.value = !superAdminOpen.value
}

const isSuperAdmin = computed(() => props.user?.id_role === 1)

</script>

