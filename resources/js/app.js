import './bootstrap';
import '../css/app.css';
import '../css/timeline.css';
import '../css/animations.css';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';

const app = createApp(App);
const pinia = createPinia();

app.use(pinia);
app.mount('#app');
