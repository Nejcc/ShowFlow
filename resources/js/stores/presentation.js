import { defineStore } from 'pinia';

export const usePresentationStore = defineStore('presentation', {
  state: () => ({
    currentSlide: 0,
    slides: [
      {
        id: 1,
        title: 'Welcome',
        type: 'content',
        content: 'Welcome to the Developer Talk!',
        code: null
      },
      {
        id: 2,
        title: 'Live Code Demo',
        type: 'code',
        content: 'Let\'s look at some code!',
        code: {
          language: 'javascript',
          content: `function helloWorld() {
  console.log('Hello, World!');
}`
        }
      }
    ]
  }),
  
  getters: {
    currentSlideData: (state) => state.slides[state.currentSlide],
    totalSlides: (state) => state.slides.length
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