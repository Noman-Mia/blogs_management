<template>
    <div class="container mt-5">
      <div class="card shadow">
        <div class="card-body">
          <h2>{{ post.title }}</h2>
          
          <!-- Show the image -->
          <img v-if="post.image" :src="`/storage/${post.image}`" alt="Blog Image" class="img-fluid mb-3" />
          
          <p>{{ post.content }}</p>
  
          <p class="text-muted">By: {{ post.user.email }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  // Props to receive data from Inertia
  const props = defineProps({
    post: Object,
  })
  </script>
  
  <style scoped>
  .card {
    border: 1px solid #ddd;
  }
  </style>
  