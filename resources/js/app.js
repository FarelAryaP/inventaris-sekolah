import { createApp } from 'vue';
import Dashboard from './Components/Dashboard.vue';
import PengajuanSaya from './Components/PengajuanSaya.vue';
import PengajuanCreate from './Components/PengajuanCreate.vue';
import PengajuanDetail from './Components/PengajuanDetail.vue'
import Layout from "./Components/Layout.vue";

const app = createApp({});
app.component('dashboard', Dashboard);
app.component('pengajuan-saya', PengajuanSaya);
app.component('pengajuan-create', PengajuanCreate);
app.component('pengajuan-detail', PengajuanDetail)
app.component("Layout", Layout);
app.mount('#app');