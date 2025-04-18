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
import { computed, ref, onMounted, watch, markRaw } from 'vue';

// Import all slide pages
const pages = import.meta.glob('../slides/pages/*.vue', { eager: true });

const store = usePresentationStore();
const { currentSlideData, slides } = storeToRefs(store);

const isLoading = ref(false);
const currentSlideComponent = ref(null);
const loadedComponents = new Map();

const contentLines = computed(() => {
  if (currentSlideData.value?.type !== 'text') return [];
  const content = currentSlideData.value?.content || '';
  return content.split('\n').filter(line => line.trim() !== '');
});

const loadComponent = async (pageNumber) => {
  if (!pageNumber) return null;

  const pagePath = `../slides/pages/${pageNumber}.vue`;
  const pageModule = pages[pagePath];
  
  if (!pageModule) {
    console.warn(`Component not found for page ${pageNumber}`);
    return null;
  }

  try {
    const component = pageModule.default;
    return markRaw(component);
  } catch (error) {
    console.error('Error loading slide component:', error);
    return null;
  }
};

const prefetchNextSlide = async () => {
  const currentIndex = slides.value.findIndex(slide => slide.id === currentSlideData.value.id);
  const nextSlide = slides.value[currentIndex + 1];
  
  if (nextSlide?.type === 'component' && nextSlide.page && !loadedComponents.has(nextSlide.page)) {
    const component = await loadComponent(nextSlide.page);
    if (component) {
      loadedComponents.set(nextSlide.page, component);
    }
  }
};

// Load current slide
const loadCurrentSlide = async () => {
  if (currentSlideData.value?.type !== 'component') {
    currentSlideComponent.value = null;
    return;
  }
  
  const pageNumber = currentSlideData.value.page;
  if (!pageNumber) {
    currentSlideComponent.value = null;
    return;
  }

  try {
    isLoading.value = true;
    
    // Check if component is already loaded
    if (loadedComponents.has(pageNumber)) {
      currentSlideComponent.value = loadedComponents.get(pageNumber);
    } else {
      const component = await loadComponent(pageNumber);
      if (component) {
        loadedComponents.set(pageNumber, component);
        currentSlideComponent.value = component;
      }
    }
    
    // Prefetch next slide
    await prefetchNextSlide();
  } catch (error) {
    console.error('Error loading slide component:', error);
    currentSlideComponent.value = null;
  } finally {
    isLoading.value = false;
  }
};

// Watch for changes in the current slide data
watch(currentSlideData, () => {
  loadCurrentSlide();
}, { immediate: true });

// Also watch for changes in the page number
watch(() => currentSlideData.value?.page, () => {
  loadCurrentSlide();
});
</script> 