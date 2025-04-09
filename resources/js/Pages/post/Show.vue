<template>
    <div>
      <!-- Display Comments -->
      <div v-for="comment in comments" :key="comment.id">
        <p><strong>{{ comment.user }}</strong>: {{ comment.content }}</p>
      </div>
  
      <!-- Comment Form -->
      <textarea v-model="newComment" placeholder="Type a comment..."></textarea>
      <button @click="postComment">Post Comment</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import Pusher from 'pusher-js'
  import { usePage } from '@inertiajs/vue3'
  import axios from 'axios'
  
  // Store comments and the new comment input
  const comments = ref(usePage().props.comments || [])
  const newComment = ref('')
  const postId = usePage().props.post.id
  
  // Pusher setup
  onMounted(() => {
    Pusher.logToConsole = true;  // Optional, to see logs in the console
    const pusher = new Pusher('your-app-key', {
      cluster: 'your-cluster',
      forceTLS: true
    });
  
    // Subscribe to the channel for this specific post
    const channel = pusher.subscribe('post.' + postId);
  
    // Listen for the 'CommentPosted' event
    channel.bind('App\\Events\\CommentPosted', function(data) {
      // Add the new comment to the list of comments
      comments.value.push({
        id: data.id,
        user: data.user,
        content: data.content
      });
    });
  });
  
  // Function to post a comment
  const postComment = async () => {
    try {
      const response = await axios.post(`/posts/${postId}/comments`, {
        content: newComment.value
      });
  
      newComment.value = '';  // Reset the input after posting
    } catch (error) {
      console.error('Error posting comment:', error);
    }
  }
  </script>
  