<template>
    <div>
      <!-- About Blog Section -->
      <section id="about-blog" class="bg-light py-5">
        <div class="container">
          <h2 class="text-dark">About My Blog</h2>
          <p class="text-muted">
            Welcome to MyBlog, a platform where you can share your thoughts, ideas, and experiences with the world. Whether you're passionate about technology, lifestyle, or any other topic, MyBlog offers a space to express yourself and connect with others.
          </p>
        </div>
      </section>
  
      <!-- Blogs Section -->
      <section id="blogs" class="py-5">
        <div class="container">
          <h2 class="text-primary">Blog Posts</h2>
          <div class="row">
            <!-- Loop through the blog posts -->
            <div v-for="post in posts" :key="post.id" class="col-md-4 mb-4">
              <div class="card">
                <!-- Displaying Post Image -->
                <img :src="`/storage/${post.image}`" class="card-img-top" alt="Post Image" />
                <div class="card-body">
                  <h5 class="card-title text-dark">{{ post.title }}</h5>
                  <p class="card-text text-muted">{{ post.content.slice(0, 100) }}...</p>
                  <Link :href="`/post/${post.id}`" class="btn btn-primary">Read More</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Other sections like category, blog posts, etc. -->
    </div>
  </template>
  
  <script setup>
  import { usePage } from '@inertiajs/vue3';
  
  // Fetching the posts data passed by the controller
  const { posts } = usePage().props;
  </script>
  
  <style scoped>
  #blogs {
    padding: 30px 0;
  }
  
  .card-img-top {
    height: 200px;
    object-fit: cover;
  }
  
  .card-body {
    padding: 15px;
  }
  
  .card-title {
    font-size: 1.2rem;
    font-weight: bold;
  }
  
  .card-text {
    font-size: 1rem;
    color: #555;
  }
  </style>
  