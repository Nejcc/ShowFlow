<template>
  <div 
    class="w-full h-full flex flex-col items-center justify-center p-8 transition-all duration-500"
    :class="[currentSlideData.background, currentSlideData.textColor]"
  >
    <div v-if="isLoading" class="text-white text-xl text-bounce">
      Loading slide...
    </div>
    <component
      v-else-if="currentSlideComponent"
      :is="currentSlideComponent"
      v-bind="currentSlideData.props || {}"
      :key="currentSlideData.id"
    />
    <template v-else>
      <transition
        enter-active-class="text-fade-down duration-500"
        leave-active-class="text-fade-up duration-500"
      >
        <h1 class="text-4xl font-bold mb-8">{{ currentSlideData.title }}</h1>
      </transition>
      <transition
        enter-active-class="text-fade-up duration-500 delay-200"
        leave-active-class="text-fade-down duration-500"
      >
        <div class="text-xl text-left max-w-2xl w-full">
          <!-- Text Content -->
          <template v-if="currentSlideData.type === 'text'">
            <div v-for="(line, index) in contentLines" 
              :key="index" 
              class="mb-2 text-fade-up"
              :style="{ animationDelay: `${index * 0.1}s` }"
            >
              {{ line }}
            </div>
          </template>

          <!-- HTML Content -->
          <template v-else-if="currentSlideData.type === 'html'">
            <div v-html="currentSlideData.content" class="text-fade-up"></div>
          </template>

          <!-- Fallback for unknown types -->
          <template v-else>
            <div class="text-red-500 text-bounce">
              Unknown content type: {{ currentSlideData.type }}
            </div>
          </template>
        </div>
      </transition>
    </template>
  </div>
</template>

<script setup>
import { storeToRefs } from 'pinia';
import { usePresentationStore } from '../stores/presentation';
import { computed, ref, onMounted, watch, markRaw, defineAsyncComponent } from 'vue';

// Lazy load slide pages
const pages = import.meta.glob('../slides/pages/*.vue');

const store = usePresentationStore();
const { currentSlideData, slides } = storeToRefs(store);

const isLoading = ref(false);
const currentSlideComponent = computed(() => {
  if (currentSlideData.value.type !== 'component') return null;
  
  const page = currentSlideData.value.page;
  if (!page) return null;

  const componentPath = `../slides/pages/${page}.vue`;
  if (!pages[componentPath]) return null;

  return defineAsyncComponent({
    loader: () => pages[componentPath](),
    loadingComponent: {
      template: '<div class="text-white text-xl">Loading slide...</div>'
    },
    delay: 200,
    timeout: 3000,
    errorComponent: {
      template: '<div class="text-red-500">Error loading slide</div>'
    }
  });
});

const contentLines = computed(() => {
  if (currentSlideData.value.type !== 'text') return [];
  return currentSlideData.value.content.split('\n').filter(line => line.trim());
});

// Preload next slide
watch(() => currentSlideData.value, async (newSlide) => {
  if (newSlide.type === 'component' && newSlide.page) {
    const nextPage = newSlide.page + 1;
    const nextComponentPath = `../slides/pages/${nextPage}.vue`;
    if (pages[nextComponentPath]) {
      await pages[nextComponentPath]();
    }
  }
}, { immediate: true });
</script> 