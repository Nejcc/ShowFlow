<template>
  <BaseLayout v-bind="$props">
    <template #content>
      <div class="grid grid-cols-2 gap-8 w-full">
        <div class="flex flex-col justify-center">
          <slot name="left"></slot>
        </div>
        <div class="flex flex-col justify-center">
          <slot name="right"></slot>
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
  }
});
</script> 