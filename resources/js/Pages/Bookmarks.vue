<template>
  <div class="container mt-5">
    <h1>Your Bookmarks</h1>
    <div v-if="bookmarks.length === 0">You have no bookmarks yet.</div>
    <ul>
      <li v-for="bookmark in bookmarks" :key="bookmark.id">
        <div>
          <p>Bookmark ID: {{ bookmark.id }}</p>
          <p>Post Title: {{ bookmark.post ? bookmark.post.title : 'No post found' }}</p>
        </div>
        <Link :href="`/bookmarks/${bookmark.post.id}`">
          {{ bookmark.post.title }}
        </Link>
      </li>
    </ul>
  </div>
</template>

  
  <script setup>
 import { usePage } from '@inertiajs/vue3';
const bookmarks = usePage().props.bookmarks;

  </script>
  
  <style scoped>
  /* Add custom styles if needed */
  </style>
  