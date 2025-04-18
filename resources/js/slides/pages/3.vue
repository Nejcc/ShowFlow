<template>
  <GridLayout
    title="Our Services"
    background="bg-gradient-to-r from-green-500 to-blue-600"
    text-color="text-white"
    :items="services"
  />
</template>

<script setup>
import GridLayout from '../../layouts/GridLayout.vue';

const services = [
  {
    title: 'Web Development',
    description: 'Modern web applications using Vue.js and Laravel'
  },
  {
    title: 'Mobile Apps',
    description: 'Cross-platform mobile applications'
  },
  {
    title: 'UI/UX Design',
    description: 'Beautiful and intuitive user interfaces'
  },
  {
    title: 'Cloud Solutions',
    description: 'Scalable cloud infrastructure'
  },
  {
    title: 'DevOps',
    description: 'Automated deployment and monitoring'
  },
  {
    title: 'Consulting',
    description: 'Expert advice and guidance'
  }
];
</script> 