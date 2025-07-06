<template>
    <div>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Blog Site</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <Link class="nav-link" href="/dashboard">My Dashboard</Link>
            </li>
            <li class="nav-item">
              <Link class="nav-link" href="/dashall">All Posts</Link>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <img :src="user.img ? '/' + user.img : '/uploads/default.jpg'" class="rounded-circle" width="30" height="30">
                <span class="ml-2">{{ user.name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <form @submit.prevent="logout">
                  <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </nav>
  
      <!-- Alerts -->
      <div class="container mt-3" v-if="success">
        <div class="alert alert-success">{{ success }}</div>
      </div>
  
      <!-- Posts -->
      <div class="container mt-3">
        <h2 class="text-center">{{ user.name }}'s Blog Posts</h2>
        <Link href="/posts/create" class="btn btn-primary btn-sm mb-3">Create New Blog</Link>
  
        <table class="table table-bordered" v-if="user.posts.length > 0">
          <thead>
            <tr>
              <th>Image</th>
              <th>Title</th>
              <th>Content</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in user.posts" :key="post.id">
              <td>
                <img :src="'/' + post.img" alt="Image" width="100" />
              </td>
              <td>{{ post.title }}</td>
              <td>{{ post.content }}</td>
              <td>{{ post.visibility }}</td>
              <td>
                <Link :href="`/posts/${post.id}/edit`" class="btn btn-primary btn-sm">Edit</Link>
                <form :action="`/posts/${post.id}`" method="POST" @submit.prevent="deletePost(post.id)" style="display:inline;">
                  <button class="btn btn-danger btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
        <p v-else>You don't have any posts yet.</p>
      </div>
    </div>
  </template>
  
  <script>
  import { Link, useForm } from '@inertiajs/vue3'
  
  export default {
    props: {
      user: Object,
      success: String,
    },
    methods: {
      logout() {
        this.$inertia.post('/logout')
      },
      deletePost(id) {
        if (confirm('Are you sure you want to delete this post?')) {
          this.$inertia.delete(`/posts/${id}`)
        }
      }
    }
  }
  </script>
  