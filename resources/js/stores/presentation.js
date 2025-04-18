import { defineStore } from 'pinia';
import axios from 'axios';

// Import slide pages dynamically
const pages = import.meta.glob('../slides/pages/*.vue');

export const usePresentationStore = defineStore('presentation', {
  state: () => ({
    currentSlide: 0,
    slides: [],
    isLoading: false,
    error: null,
    slideCache: new Map(),
    lastFetchTime: null
  }),
  
  getters: {
    currentSlideData: (state) => state.slides[state.currentSlide] || {},
    totalSlides: (state) => state.slides.length,
    progress: (state) => state.slides.length ? ((state.currentSlide + 1) / state.slides.length) * 100 : 0,
    isFirstSlide: (state) => state.currentSlide === 0,
    isLastSlide: (state) => state.currentSlide === state.slides.length - 1
  },
  
  actions: {
    async fetchSlides() {
      // Check if we need to fetch (not loaded or stale)
      const now = Date.now();
      const isStale = this.lastFetchTime && (now - this.lastFetchTime > 5 * 60 * 1000); // 5 minutes

      if (this.slides.length && !isStale) {
        return;
      }

      this.isLoading = true;
      this.error = null;
      
      try {
        const response = await axios.get('/presentation');
        this.slides = response.data.slides;
        this.currentSlide = response.data.currentSlide;
        this.lastFetchTime = now;
        
        // Preload first few slides
        this.preloadSlides(0, 2);
      } catch (error) {
        this.error = error.message;
        console.error('Error fetching slides:', error);
      } finally {
        this.isLoading = false;
      }
    },

    preloadSlides(startIndex, count) {
      const endIndex = Math.min(startIndex + count, this.slides.length);
      for (let i = startIndex; i < endIndex; i++) {
        const slide = this.slides[i];
        if (slide.type === 'component' && slide.page) {
          this.loadSlideComponent(slide.page);
        }
      }
    },

    async loadSlideComponent(pageNumber) {
      if (this.slideCache.has(pageNumber)) {
        return this.slideCache.get(pageNumber);
      }

      try {
        const componentPath = `../slides/pages/${pageNumber}.vue`;
        if (pages[componentPath]) {
          const component = await pages[componentPath]();
          this.slideCache.set(pageNumber, component);
          return component;
        }
        return null;
      } catch (error) {
        console.error(`Error loading slide ${pageNumber}:`, error);
        return null;
      }
    },

    nextSlide() {
      if (this.currentSlide < this.slides.length - 1) {
        this.currentSlide++;
        // Preload next slides
        this.preloadSlides(this.currentSlide + 1, 2);
      }
    },

    previousSlide() {
      if (this.currentSlide > 0) {
        this.currentSlide--;
      }
    },

    goToSlide(index) {
      if (index >= 0 && index < this.slides.length) {
        this.currentSlide = index;
        // Preload surrounding slides
        this.preloadSlides(Math.max(0, index - 1), 3);
      }
    },

    clearCache() {
      this.slideCache.clear();
      this.lastFetchTime = null;
    }
  }
}); 