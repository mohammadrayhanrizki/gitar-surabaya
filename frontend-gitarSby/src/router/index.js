// src/router/index.js

import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue' // Pastikan baris ini ada

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/', // <-- INI YANG PENTING
      name: 'home',
      component: HomeView // Memberitahu router untuk menampilkan HomeView.vue
    },
    // Mungkin ada rute lain seperti /about, biarkan saja
  ]
})

export default router