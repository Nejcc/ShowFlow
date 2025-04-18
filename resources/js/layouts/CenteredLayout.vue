<template>
  <BaseLayout v-bind="$props">
    <template #content>
      <div class="text-center">
        <slot></slot>
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
  }
});
</script> 