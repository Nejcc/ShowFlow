<template>
  <TimelineLayout
    title="Project Timeline"
    background="bg-gradient-to-r from-purple-500 to-pink-600"
    text-color="text-white"
    :items="timeline"
  />
</template>

<script setup>
import TimelineLayout from '../../layouts/TimelineLayout.vue';

const timeline = [
  {
    title: 'Project Initiation',
    description: 'Understanding requirements and planning'
  },
  {
    title: 'Design Phase',
    description: 'Creating wireframes and UI/UX designs'
  },
  {
    title: 'Development',
    description: 'Building the application with modern technologies'
  },
  {
    title: 'Testing',
    description: 'Ensuring quality and performance'
  },
  {
    title: 'Deployment',
    description: 'Launching the product to production'
  },
  {
    title: 'Maintenance',
    description: 'Ongoing support and updates'
  }
];
</script> 