<template>
    <div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><b>Blog Site</b></a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item"><Link class="nav-link active" href="/dashboard">My Dashboard</Link></li>
            <li class="nav-item"><Link class="nav-link active" href="/dashall">All Posts</Link></li>
            <li class="nav-item"><Link class="nav-link" :href="route('user.bookmarks')">My Bookmarks</Link></li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
                <img :src="userImg" width="30" height="30" class="rounded-circle mr-2" />
                <span class="text-dark">{{ LoggedUser?.name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <form @submit.prevent="logout">
                  <button type="submit" class="dropdown-item text-danger">
                    Logout
                  </button>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </nav>
  
      <main class="container my-4">
        <h1 class="text-center">Our Blog Site</h1>
        <h6 class="border-bottom pb-2 mb-4">Recent updates</h6>
  
        <form @submit.prevent="searchPosts" class="mb-4">
          <div class="input-group">
            <input type="text" v-model="search" class="form-control" placeholder="Search posts..." />
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
          </div>
        </form>
  
        <div class="row">
          <div v-for="post in posts.data" :key="post.id" class="col-md-4 mb-4">
            <div class="card">
              <img v-if="post.img" :src="`/${post.img}`" class="img-fluid mb-2" style="max-height: 300px;" />
  
              <div class="card-body">
                <h5>Created By: {{ post.user?.name || 'Unknown User' }}</h5>
                <h6>Title: {{ post.title }}</h6>
                <p>Content: {{ post.content }}</p>
                <p>Created At: {{ post.created_at }}</p>
  
                <p v-if="post.tags.length">
                  Tags:
                  <span v-for="tag in post.tags" :key="tag.id" class="badge badge-info mr-1">{{ tag.name }}</span>
                </p>
  
                <!-- Like Button -->
                <form @submit.prevent="toggleLike(post)">
                  <button :class="['btn btn-sm', post.liked ? 'btn-danger' : 'btn-outline-primary']">
                    {{ post.liked ? 'Unlike' : 'Like' }}
                  </button>
                  <span class="ml-2">{{ post.likes_count }} Likes</span>
                </form>
  
                <!-- Bookmark Button -->
                <form @submit.prevent="toggleBookmark(post)">
                  <button :class="['btn btn-sm', post.isBookmarked ? 'btn-danger' : 'btn-outline-primary']">
                    {{ post.isBookmarked ? 'Unbookmark' : 'Bookmark' }}
                  </button>
                </form>
  
                <!-- Comment Form -->
                <form @submit.prevent="submitComment(post.id)">
                  <textarea v-model="newComment[post.id]" class="form-control mb-2" placeholder="Add a comment..."></textarea>
                  <button class="btn btn-sm btn-primary" type="submit">Post Comment</button>
                </form>
  
                <!-- Comments -->
                <div class="mt-3">
                  <Comment v-for="comment in post.comments" :key="comment.id" :comment="comment" :postId="post.id" />
                </div>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Pagination -->
        <Pagination :links="posts.links" />
      </main>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { router, Link, usePage } from '@inertiajs/vue3'
  import Comment from '@/Components/Comment.vue'
  import Pagination from '@/Components/Pagination.vue'
  
  const { posts, LoggedUser, search: initialSearch } = usePage().props
  
  const search = ref(initialSearch || '')
  const newComment = ref({})
  
  const userImg = LoggedUser?.img ? `/${LoggedUser.img}` : '/uploads/default.jpg'
  
  const searchPosts = () => {
    router.get(route('user.dashall'), { search: search.value }, { preserveState: true })
  }
  
  const toggleLike = (post) => {
    router.post(route('post.like.toggle'), { post_id: post.id }, {
      preserveScroll: true,
      onSuccess: () => {
        post.liked = !post.liked
        post.likes_count += post.liked ? 1 : -1
      }
    })
  }
  
  const toggleBookmark = (post) => {
    router.post(route('bookmark.toggle', post.id), {}, {
      preserveScroll: true,
      onSuccess: () => {
        post.isBookmarked = !post.isBookmarked
      }
    })
  }
  
  const submitComment = (postId) => {
    router.post(route('comments.store', postId), {
      body: newComment.value[postId],
      parent_id: null
    }, {
      preserveScroll: true,
      onSuccess: () => {
        newComment.value[postId] = ''
      }
    })
  }
  
  const logout = () => {
    router.post(route('user.logout'))
  }
  </script>
  
  <style scoped>
  .container {
    max-width: 1200px;
  }
  </style>
  