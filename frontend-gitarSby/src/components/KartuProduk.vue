// src/components/KartuProduk.vue

<script setup>
// Untuk sementara, bagian script kita biarkan kosong.
</script>

<template>
  <div class="produk-kartu">
    <img src="https://via.placeholder.com/250" alt="Gambar Gitar" />
    <h3>Ini Kartu Produk</h3>
    <p class="harga">Rp 1.000.000</p>
    <button>Pesan via WhatsApp</button>
  </div>
</template>

<style scoped>
  .produk-kartu {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 1rem;
    width: 280px;
    text-align: center;
    background-color: white;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }
  .produk-kartu img {
    max-width: 100%;
    height: auto;
    margin-bottom: 1rem;
  }
  .produk-kartu h3 {
    margin: 0.5rem 0;
  }
  .produk-kartu .harga {
    font-size: 1.2rem;
    font-weight: bold;
    color: #2c3e50;
    margin-bottom: 1rem;
  }
  .produk-kartu button {
    background-color: #25D366;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }
</style>