<template>
  <div class="presentation-container" ref="presentationContainer" @keydown="handleKeyDown">
    <!-- Loading State -->
    <div v-if="store.isLoading" class="fixed inset-0 flex items-center justify-center bg-black/50">
      <div class="text-white text-2xl">Loading presentation...</div>
    </div>

    <!-- Error State -->
    <div v-else-if="store.error" class="fixed inset-0 flex items-center justify-center bg-red-500/50">
      <div class="text-white text-2xl">Error: {{ store.error }}</div>
    </div>

    <!-- Presentation Content -->
    <template v-else>
      <!-- Fullscreen Toggle Button -->
      <button 
        @click="toggleFullscreen"
        class="fixed top-4 right-4 p-2 bg-white/10 rounded-lg backdrop-blur-sm hover:bg-white/20 transition-colors"
        :title="isFullscreen ? 'Exit Fullscreen' : 'Enter Fullscreen'"
      >
        <svg v-if="!isFullscreen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m0 0v4m0-4l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5h-4m0 0v-4m0 4l-5-5" />
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <transition
        :name="slideTransition"
        mode="out-in"
      >
        <div 
          :key="store.currentSlide"
          class="slide-container"
          :class="[currentSlide.background, currentSlide.textColor]"
        >
          <Slide />
        </div>
      </transition>

      <!-- Page Indicator -->
      <div class="page-indicator">
        {{ store.currentSlide + 1 }}/{{ store.totalSlides }}
      </div>
    </template>
  </div>
</template>

<script setup>
import { usePresentationStore } from '../stores/presentation';
import { storeToRefs } from 'pinia';
import { onMounted, onUnmounted, ref, computed } from 'vue';
import Slide from './Slide.vue';

const store = usePresentationStore();
const { currentSlide } = storeToRefs(store);
const presentationContainer = ref(null);
const isFullscreen = ref(false);
const lastDirection = ref('right');

const slideTransition = computed(() => {
  return lastDirection.value === 'right' ? 'slide-fade-right' : 'slide-fade-left';
});

const toggleFullscreen = async () => {
  if (!document.fullscreenElement) {
    try {
      await presentationContainer.value.requestFullscreen();
      isFullscreen.value = true;
    } catch (err) {
      console.error('Error attempting to enable fullscreen:', err);
    }
  } else {
    try {
      await document.exitFullscreen();
      isFullscreen.value = false;
    } catch (err) {
      console.error('Error attempting to exit fullscreen:', err);
    }
  }
};

const handleKeyDown = (event) => {
  switch(event.key) {
    case 'ArrowLeft':
      lastDirection.value = 'left';
      store.previousSlide();
      break;
    case 'ArrowRight':
      lastDirection.value = 'right';
      store.nextSlide();
      break;
    case 'f':
      toggleFullscreen();
      break;
  }
};

onMounted(async () => {
  await store.fetchSlides();
  window.addEventListener('keydown', handleKeyDown);
  document.addEventListener('fullscreenchange', () => {
    isFullscreen.value = !!document.fullscreenElement;
  });
});

onUnmounted(() => {
  window.removeEventListener('keydown', handleKeyDown);
  document.removeEventListener('fullscreenchange', () => {
    isFullscreen.value = !!document.fullscreenElement;
  });
});
</script>

<style scoped>
.presentation-container {
  @apply h-screen w-screen overflow-hidden;
}

.slide-container {
  @apply h-full w-full flex items-center justify-center;
}

.page-indicator {
  @apply fixed bottom-6 right-6 text-gray-400 text-lg font-mono;
}

.slide-fade-right-enter-active,
.slide-fade-right-leave-active,
.slide-fade-left-enter-active,
.slide-fade-left-leave-active {
  @apply transition-all duration-700 ease-in-out;
}

.slide-fade-right-enter-from {
  @apply transform translate-x-full opacity-0;
}

.slide-fade-right-leave-to {
  @apply transform -translate-x-full opacity-0;
}

.slide-fade-left-enter-from {
  @apply transform -translate-x-full opacity-0;
}

.slide-fade-left-leave-to {
  @apply transform translate-x-full opacity-0;
}
</style> 