import { defineStore } from 'pinia';

export const usePresentationStore = defineStore('presentation', {
  state: () => ({
    currentSlide: 0,
    slides: [
      {
        id: 1,
        title: 'Hello World!',
        type: 'content',
        content: 'Welcome to this presentation',
        background: 'bg-gradient-to-r from-blue-500 to-purple-600',
        textColor: 'text-white'
      },
      {
        id: 2,
        title: 'Slide 1',
        type: 'content',
        content: 'This is the first numbered slide',
        background: 'bg-white'
      },
      {
        id: 3,
        title: 'Slide 2',
        type: 'content',
        content: 'This is the second numbered slide',
        background: 'bg-gray-50'
      },
      {
        id: 4,
        title: 'Slide 3',
        type: 'content',
        content: 'This is the third numbered slide',
        background: 'bg-white'
      },
      {
        id: 5,
        title: 'Created By',
        type: 'content',
        content: 'This presentation was created with Vue Presenter',
        background: 'bg-gradient-to-r from-green-400 to-blue-500',
        textColor: 'text-white'
      }
    ]
  }),
  
  getters: {
    currentSlideData: (state) => state.slides[state.currentSlide],
    totalSlides: (state) => state.slides.length,
    progress: (state) => ((state.currentSlide + 1) / state.slides.length) * 100
  },
  
  actions: {
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