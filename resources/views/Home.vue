Home.vue<template>
    <div class="container">
      <h1 class="text-center">Our Blog Site</h1>
      <h6 class="border-bottom border-gray pb-2 mb-4">Recent updates</h6>
  
      <div class="row">
        <div class="col-md-4 mb-4" v-for="post in posts.data" :key="post.id">
          <div class="card">
            <img v-if="post.img" :src="`/${post.img}`" alt="Post Image" class="img-fluid mb-2" style="max-height: 300px;">
            
            <div class="card-body">
              <h5 class="card-title">Created By: {{ post.user ? post.user.name : 'Unknown User' }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">Title: {{ post.title }}</h6>
              <p class="card-text">Content: {{ post.content }}</p>
              <p class="card-text">Created At: {{ post.created_at }}</p>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Pagination -->
      <div class="pagination">
        <inertia-link v-if="posts.prev_page_url" :href="posts.prev_page_url" class="btn btn-primary">Previous</inertia-link>
        <inertia-link v-if="posts.next_page_url" :href="posts.next_page_url" class="btn btn-primary">Next</inertia-link>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      posts: Object,  // Paginated posts data
    },
  };
  </script>
  
  <style scoped>
  /* Add any custom styles you need */
  </style>
  