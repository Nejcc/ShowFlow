<template>
  <CenteredLayout
    title="Welcome to Our Presentation"
    background="bg-gradient-to-r from-blue-500 to-purple-600"
    text-color="text-white"
  >
    <div class="text-2xl mb-4">This is a sample presentation</div>
    <p class="mb-4">Created with Laravel and Vue.js</p>
    <p>Use the arrow keys to navigate between slides</p>
  </CenteredLayout>
</template>

<script setup>
import CenteredLayout from '../../layouts/CenteredLayout.vue';
</script> 