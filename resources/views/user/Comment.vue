<template>
    <div class="comment mt-3 border p-2 rounded">
      <strong>{{ comment.user.name }}</strong> 
      <small class="text-muted">{{ formatDate(comment.created_at) }}</small>
      <p>{{ comment.body }}</p>
  
      <div>
        <button @click="toggleReplyForm" class="reply-toggle btn btn-sm btn-link">Reply</button>
  
        <!-- Show delete button if the current user is the post owner -->
        <div v-if="canDeleteComment">
          <button @click="deleteComment(comment.id)" class="btn btn-sm btn-danger" 
                  :disabled="isDeleting">
            Delete
          </button>
        </div>
      </div>
  
      <!-- Reply form (initially hidden, toggled via Vue.js) -->
      <div v-if="showReplyForm" class="reply-form mt-2">
        <textarea v-model="replyBody" class="form-control" rows="2" placeholder="Write a reply..."></textarea>
        <button @click="submitReply" class="btn btn-sm btn-primary" :disabled="isSubmitting">
          Post Reply
        </button>
      </div>
  
      <!-- Recursive display of child comments -->
      <div v-if="comment.replies && comment.replies.length" class="nested-comment mt-3 ml-4">
        <Comment v-for="reply in comment.replies" :key="reply.id" :comment="reply" :post="post" />
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { Inertia } from '@inertiajs/inertia';
  import { InertiaLink } from '@inertiajs/inertia-vue3';
  import Comment from './Comment.vue'; // Import the comment component recursively
  
  export default {
    props: {
      comment: Object,
      post: Object,
    },
    components: {
      Comment,
    },
    setup(props) {
      const showReplyForm = ref(false);
      const replyBody = ref('');
      const isSubmitting = ref(false);
      const isDeleting = ref(false);
  
      const canDeleteComment = props.comment.user.id === props.post.user_id;
  
      const toggleReplyForm = () => {
        showReplyForm.value = !showReplyForm.value;
      };
  
      const submitReply = () => {
        if (!replyBody.value.trim()) return;
  
        isSubmitting.value = true;
        Inertia.post(route('comments.store', { postId: props.post.id }), {
          body: replyBody.value,
          parent_id: props.comment.id,
        }).then(() => {
          replyBody.value = '';
          showReplyForm.value = false;
          isSubmitting.value = false;
        });
      };
  
      const deleteComment = (commentId) => {
        if (confirm('Delete this comment?')) {
          isDeleting.value = true;
          Inertia.delete(route('comments.destroy', commentId))
            .then(() => {
              isDeleting.value = false;
            });
        }
      };
  
      const formatDate = (dateString) => {
        return new Date(dateString).toLocaleString();
      };
  
      return {
        showReplyForm,
        replyBody,
        isSubmitting,
        isDeleting,
        canDeleteComment,
        toggleReplyForm,
        submitReply,
        deleteComment,
        formatDate,
      };
    },
  };
  </script>
  
  <style scoped>
  /* Add custom styling for comments */
  </style>
  