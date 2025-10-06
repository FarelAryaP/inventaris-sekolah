import { createApp } from 'vue';
import '../css/app.css';

// Import komponen
import ExampleComponent from './components/ExampleComponent.vue';
import LoginUser from './components/LoginUser.vue';
import LoginAdmin from './components/LoginAdmin.vue';
import DashboardLayout from './components/DashboardLayout.vue';
// Buat aplikasi VueAC
const app = createApp({});

// Register komponen global
app.component('example-component', ExampleComponent);
app.component('login-user', LoginUser);
app.component('login-admin', LoginAdmin);
app.component('dashboard-layout', DashboardLayout);
// Mount ke elemen Blade
app.mount('#app');
