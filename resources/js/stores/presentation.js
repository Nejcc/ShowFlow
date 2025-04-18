import { defineStore } from 'pinia';
import axios from 'axios';

export const usePresentationStore = defineStore('presentation', {
  state: () => ({
    currentSlide: 0,
    slides: [],
    isLoading: false,
    error: null
  }),
  
  getters: {
    currentSlideData: (state) => state.slides[state.currentSlide] || {},
    totalSlides: (state) => state.slides.length,
    progress: (state) => state.slides.length ? ((state.currentSlide + 1) / state.slides.length) * 100 : 0
  },
  
  actions: {
    async fetchSlides() {
      this.isLoading = true;
      this.error = null;
      
      try {
        const response = await axios.get('/presentation');
        this.slides = response.data.slides;
        this.currentSlide = response.data.currentSlide;
      } catch (error) {
        this.error = error.message;
        console.error('Error fetching slides:', error);
      } finally {
        this.isLoading = false;
      }
    },

    nextSlide() {
      if (this.currentSlide < this.slides.length - 1) {
        this.currentSlide++;
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
      }
    }
  }
}); 