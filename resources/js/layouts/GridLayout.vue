<template>
  <BaseLayout v-bind="$props">
    <template #content>
      <div class="grid grid-cols-3 gap-6 w-full">
        <div v-for="(item, index) in items" :key="index" class="flex flex-col items-center p-4 bg-white/10 rounded-lg">
          <div class="text-2xl font-bold mb-2">{{ item.title }}</div>
          <p class="text-center">{{ item.description }}</p>
        </div>
      </div>
    </template>
  </BaseLayout>
</template>

<script setup>
import BaseLayout from './BaseLayout.vue';

defineProps({
  title: {
    type: String,
    required: true
  },
  background: {
    type: String,
    default: 'bg-white'
  },
  textColor: {
    type: String,
    default: 'text-gray-900'
  },
  items: {
    type: Array,
    required: true
  }
});
</script> 