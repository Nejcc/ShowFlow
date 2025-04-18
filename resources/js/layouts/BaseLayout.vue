<template>
  <div class="w-full h-full flex flex-col items-center justify-center p-8 transition-all duration-500"
    :class="[background, textColor]">
    <slot name="title">
      <transition
        enter-active-class="transition-all duration-700 ease-out"
        enter-from-class="opacity-0 transform translate-y-4"
        enter-to-class="opacity-100 transform translate-y-0"
        leave-active-class="transition-all duration-700 ease-in"
        leave-from-class="opacity-100 transform translate-y-0"
        leave-to-class="opacity-0 transform -translate-y-4"
      >
        <h1 class="text-4xl font-bold mb-8">{{ title }}</h1>
      </transition>
    </slot>

    <slot name="content">
      <transition
        enter-active-class="transition-all duration-700 ease-out delay-200"
        enter-from-class="opacity-0 transform translate-y-4"
        enter-to-class="opacity-100 transform translate-y-0"
        leave-active-class="transition-all duration-700 ease-in"
        leave-from-class="opacity-100 transform translate-y-0"
        leave-to-class="opacity-0 transform -translate-y-4"
      >
        <div class="text-xl text-left max-w-2xl w-full">
          <slot></slot>
        </div>
      </transition>
    </slot>
  </div>
</template>

<script setup>
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