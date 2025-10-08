import '../css/sidebar.css';
import '../css/dashboard-admin.css';
import '../css/barang.css';
import '../css/style.css';
import { createApp } from 'vue';

import ExampleComponent from './components/ExampleComponent.vue';
import Sidebar from './components/sidebar.vue';

const app = createApp({});

app.component('example-component', ExampleComponent);
app.component('sidebar-component', Sidebar);

app.mount('#app');
