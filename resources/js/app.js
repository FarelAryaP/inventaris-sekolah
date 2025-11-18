import '../css/sidebar.css';
import '../css/dashboard-admin.css';
import '../css/barang.css';
import '../css/style.css';
import '../css/pengajuan.css';
import '../css/kelola-admin.css';
import { createApp } from 'vue';

import Sidebar from './components/sidebar.vue';
import DashboardPage from './components/DashboardPage.vue';
import PengajuanPage from './components/PengajuanPage.vue';
import PeminjamanPage from './components/PeminjamanPage.vue';
import LaporanPage from './components/LaporanPage.vue';

const app = createApp({});

app.component('sidebar-component', Sidebar);
app.component('dashboard-page', DashboardPage);
app.component('pengajuan-page', PengajuanPage);
app.component('peminjaman-page', PeminjamanPage);
app.component('laporan-page', LaporanPage);

app.mount('#app');

console.log("✅ Vue berhasil dimount!");