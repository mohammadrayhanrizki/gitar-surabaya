// src/views/HomeView.vue

<script setup>
// 1. IMPORT komponen KartuProduk agar bisa dikenali di file ini.
import KartuProduk from '@/components/KartuProduk.vue'
</script>

<template>
  <div class="katalog">
    <h1>Katalog Gitar Surabaya</h1>
    
    <KartuProduk />
    
  </div>
</template>

<style scoped>
.katalog {
  padding: 2rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem; /* Memberi jarak antara judul dan kartu */
}
</style>