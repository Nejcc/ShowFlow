<template>
  <BaseLayout v-bind="$props">
    <template #content>
      <div class="timeline-container">
        <div class="timeline-line"></div>
        
        <div v-for="(item, index) in items" :key="index" class="timeline-item">
          <div class="timeline-dot"></div>
          
          <div class="timeline-content" :class="index % 2 === 0 ? 'left' : 'right'">
            <div class="timeline-title"
              :class="{
                'translate-x-4 opacity-0': index % 2 === 0,
                '-translate-x-4 opacity-0': index % 2 !== 0
              }"
              :style="{
                animation: 'slideIn 0.5s forwards',
                animationDelay: `${index * 0.1}s`
              }"
            >
              {{ item.title }}
            </div>
            
            <p class="timeline-description"
              :class="{
                'translate-x-4 opacity-0': index % 2 === 0,
                '-translate-x-4 opacity-0': index % 2 !== 0
              }"
              :style="{
                animation: 'slideIn 0.5s forwards',
                animationDelay: `${index * 0.1 + 0.2}s`
              }"
            >
              {{ item.description }}
            </p>
          </div>
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
  },
  items: {
    type: Array,
    required: true
  }
});
</script> 