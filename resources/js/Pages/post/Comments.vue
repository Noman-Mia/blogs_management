<template>
    <div>
      <form @submit.prevent="submitComment">
        <textarea v-model="newComment" placeholder="Write your comment..." class="w-full p-2 border"></textarea>
        <button type="submit" class="mt-2 bg-blue-600 text-white px-3 py-1 rounded">Post</button>
      </form>
  
      <div v-for="comment in comments" :key="comment.id" class="border-b py-2">
        <strong>{{ comment.user.name }}:</strong> {{ comment.body }}
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      postId: Number,
      authUserId: Number,
      initialComments: Array,
    },
    data() {
      return {
        newComment: '',
        comments: [...this.initialComments],
      }
    },
    mounted() {
      window.Echo.channel(`comments.${this.postId}`)
        .listen('CommentPosted', (e) => {
          this.comments.push(e.comment)
        })
    },
    methods: {
      async submitComment() {
        if (!this.newComment.trim()) return
  
        try {
          const res = await axios.post(`/posts/${this.postId}/comments`, {
            body: this.newComment,
          })
  
          this.comments.push(res.data)
          this.newComment = ''
        } catch (err) {
          console.error(err)
        }
      },
    }
  }
  </script>
  