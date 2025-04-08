<template>
  <div class="container mt-5">
    <h1>Your Bookmarks</h1>
    
    <!-- If no bookmarks -->
    <div v-if="bookmarks.length === 0">You have no bookmarks yet.</div>
    
    <!-- Display Bookmarks -->
    <ul>
      <li v-for="bookmark in bookmarks" :key="bookmark.id" class="bookmark-item">
        <div class="bookmark-content">
          <div v-if="bookmark.post">
            <!-- Show post title and content -->
            <p class="bookmark-id">Bookmark ID: {{ bookmark.id }}</p>
            <p class="bookmark-title">{{ bookmark.post.title }}</p>
            <p class="bookmark-content-text">{{ bookmark.post.content || 'No content available' }}</p>
          </div>
          <div v-else>
            <p>No post found for this bookmark.</p>
          </div>
          
          <!-- Link to the post -->
          <Link :href="`/posts/${bookmark.post.id}`">
            View Post
          </Link>

          <!-- Destroy button -->
          <button @click="destroyBookmark(bookmark.id)" class="btn btn-danger">
            Remove Bookmark
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { usePage, useForm } from '@inertiajs/vue3';
import { createToaster } from "@meforma/vue-toaster";
const toaster = createToaster({ position: "top-right" });

// Getting bookmarks from Inertia props
const { bookmarks } = usePage().props;

// Function to handle bookmark deletion
const destroyBookmark = (bookmarkId) => {
  // Use the Inertia form to send the request for destruction
  const form = useForm();
  form.delete(`/bookmarks/${bookmarkId}`, {
    onSuccess: () => {
      // Handle successful deletion and show toaster message
      toaster.success('Bookmark removed successfully!');
    },
    onError: (error) => {
      // Handle errors and show error toaster message
      toaster.error('Error removing bookmark.');
    }
  });
};
</script>

<style scoped>
.bookmark-item {
  border: 1px solid #ddd;
  padding: 10px;
  margin-bottom: 10px;
  display: flex;
  flex-direction: column;
}

.bookmark-content {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.bookmark-id {
  font-size: 1rem;
  font-weight: bold;
}

.bookmark-title {
  font-size: 1.2rem;
  font-weight: bold;
}

.bookmark-content-text {
  font-size: 1rem;
  color: #555;
}

.btn-danger {
  margin-top: 10px;
  width: 200px;
  font-size: 14px;
  background-color: red;
  color: white;
  border: none;
  cursor: pointer;
}

.btn-danger:hover {
  background-color: darkred;
}
</style>
