<template>
  <aside class="sidebar">
    <h2 class="sidebar-title">Portal Siswa</h2>

    <nav class="nav-menu">
      <a :href="routes.dashboard" :class="{ active: activeMenu === 'dashboard' }">Dashboard</a>
      <a :href="routes.pengajuanSaya" :class="{ active: activeMenu === 'pengajuan' }">Pengajuan Saya</a>
      <a :href="routes.pengajuanCreate" :class="{ active: activeMenu === 'ajukan' }">Ajukan Barang</a>
    </nav>

    <form :action="routes.logout" method="POST" class="logout-form">
      <input type="hidden" name="_token" :value="csrf">
      <button type="submit" class="logout-btn">Logout</button>
    </form>
  </aside>
</template>

<script>
export default {
  props: {
    routes: Object,
    activeMenu: String,
    csrf: String
  }
};
</script>

<style scoped>
.sidebar {
  background: linear-gradient(to bottom, #d8e4ff, #a7c7ff);
  height: 100vh;
  width: 230px;
  padding: 2rem 1rem;
  border-radius: 25px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 3px 0 10px rgba(0,0,0,0.05);
}

.sidebar-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #4a6cf7;
  margin-bottom: 2rem;
  text-align: center;
}

.nav-menu {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  text-align: center;
}

.nav-menu a {
  text-decoration: none;
  color: #333;
  font-weight: 600;
  transition: all 0.3s ease;
}

.nav-menu a:hover,
.nav-menu a.active {
  color: #4a6cf7;
  transform: translateX(4px);
}

.logout-form {
  text-align: center;
}

.logout-btn {
  background: rgba(255,255,255,0.4);
  color: #333;
  border: none;
  padding: 0.6rem 1.5rem;
  border-radius: 10px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
}
.logout-btn:hover {
  background: #4a6cf7;
  color: white;
}
</style>
