<template>
    <div class="container mt-4">
      <h1 class="text-center">My Bookmarked Posts</h1>
      <h6 class="border-bottom border-gray pb-2 mb-4">Recent updates</h6>
  
      <!-- Loop through the posts and display them as tiles -->
      <div class="row">
        <div v-for="bookmark in bookmarkedPosts" :key="bookmark.id" class="col-md-4 mb-4">
          <div class="card">
            <!-- Image -->
            <img v-if="bookmark.post.img" :src="`/${bookmark.post.img}`" alt="Post Image" class="img-fluid mb-2" style="max-height: 300px;">
            
            <div class="card-body">
              <h5 class="card-title">Created By: {{ bookmark.post.user.name || 'Unknown' }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">Title: {{ bookmark.post.title }}</h6>
              <p class="card-text">Content: {{ bookmark.post.content }}</p>
              <p class="card-text">Created At: {{ bookmark.post.created_at }}</p>
  
              <!-- Bookmark Toggle -->
              <form @submit.prevent="toggleBookmark(bookmark.post.id)">
                <button type="submit" class="btn btn-sm" :class="isBookmarked(bookmark) ? 'btn-danger' : 'btn-outline-primary'">
                  {{ isBookmarked(bookmark) ? 'Unbookmark' : 'Bookmark' }}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Pagination -->
      <pagination :links="bookmarkedPosts.links"></pagination>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  import Pagination from '@/Components/Pagination';
  
  export default {
    components: {
      Pagination,
    },
    props: {
      bookmarkedPosts: Array,
      loggedUser: Object,
    },
    methods: {
      // Check if the post is bookmarked by the logged-in user
      isBookmarked(bookmark) {
        return bookmark.post.bookmarks.some(b => b.user_id === this.loggedUser.id);
      },
      // Toggle bookmark
      toggleBookmark(postId) {
        Inertia.post(`/bookmark/toggle/${postId}`);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any additional styles here */
  </style>
  