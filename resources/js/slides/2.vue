<template>
  <SplitLayout
    title="Key Features"
    background="bg-gradient-to-r from-indigo-500 to-purple-600"
    text-color="text-white"
  >
    <template #left>
      <div class="text-2xl font-bold mb-4">Technical Features</div>
      <ul class="space-y-2">
        <li>• Vue.js 3 Composition API</li>
        <li>• Pinia for State Management</li>
        <li>• Tailwind CSS for Styling</li>
        <li>• Laravel Backend</li>
      </ul>
    </template>

    <template #right>
      <div class="text-2xl font-bold mb-4">Presentation Features</div>
      <ul class="space-y-2">
        <li>• Smooth Transitions</li>
        <li>• Keyboard Navigation</li>
        <li>• Fullscreen Mode</li>
        <li>• Custom Layouts</li>
      </ul>
    </template>
  </SplitLayout>
</template>

<script setup>
import SplitLayout from '../../layouts/SplitLayout.vue';
</script> 