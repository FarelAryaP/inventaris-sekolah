import './bootstrap';
import { createApp } from 'vue';
import '../css/app.css';

// Import semua komponen Vue
import LoginAdmin from './components/LoginAdmin.vue';
import LoginUser from './components/LoginUser.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import Dashboard from './components/Dashboard.vue';
import LaporanPeminjaman from './components/LaporanPeminjaman.vue';

// Buat instance Vue
const app = createApp({});

// Daftarkan komponen
app.component('login-admin', LoginAdmin);
app.component('login-user', LoginUser);
app.component('example-component', ExampleComponent);
app.component('dashboard', Dashboard);
app.component('laporan-peminjaman', LaporanPeminjaman);

// Mount ke elemen #app di layout admin
app.mount('#app');
