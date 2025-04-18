<template>
  <div 
    class="w-full h-full flex flex-col items-center justify-center p-8 transition-all duration-500"
    :class="[currentSlideData.background, currentSlideData.textColor]"
  >
    <h1 class="text-4xl font-bold mb-8">{{ currentSlideData.title }}</h1>
    <div class="text-xl">{{ currentSlideData.content }}</div>
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import { usePresentationStore } from '../stores/presentation';

const store = usePresentationStore();
const { currentSlideData } = storeToRefs(store);
</script> 