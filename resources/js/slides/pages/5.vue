<template>
  <CenteredLayout
    title="Created By"
    background="bg-gradient-to-r from-indigo-500 to-purple-600"
    text-color="text-white"
  >
    <div class="space-y-8">
      <h1 class="text-6xl font-bold text-bounce">
        LordNeic
      </h1>
      <p class="text-2xl opacity-90">
        A Vue.js & Laravel Presentation System
      </p>
      <div class="mt-12 text-xl space-y-4">
        <p class="text-fade-up" style="animation-delay: 0.2s">
          Built with modern web technologies
        </p>
        <p class="text-fade-up" style="animation-delay: 0.4s">
          Featuring smooth animations and transitions
        </p>
        <p class="text-fade-up" style="animation-delay: 0.6s">
          Custom layouts and dynamic content
        </p>
      </div>
    </div>
  </CenteredLayout>
</template>

<script setup>
import CenteredLayout from '../../layouts/CenteredLayout.vue';
</script> 