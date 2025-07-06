<template>
    <div class="container">
      <h1>Edit Post</h1>
  
      <!-- Error message -->
      <div v-if="$page.props.error" class="alert alert-danger">
        {{ $page.props.error }}
      </div>
  
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <!-- Title -->
        <div class="form-group">
          <label for="title">Title</label>
          <input
            type="text"
            id="title"
            v-model="form.title"
            class="form-control"
          />
        </div>
  
        <!-- Content -->
        <div class="form-group">
          <label for="content">Content</label>
          <textarea
            id="content"
            v-model="form.content"
            class="form-control"
          ></textarea>
        </div>
  
        <!-- Image -->
        <div class="form-group">
          <label for="img">Change Image</label>
          <input
            type="file"
            id="img"
            @change="handleImageUpload"
            class="form-control-file"
            accept="image/*"
          />
          <div v-if="post.img">
            <img
              :src="`/storage/${post.img}`"
              alt="Current Image"
              class="img-fluid mb-2"
              style="max-height: 300px"
            />
          </div>
        </div>
  
        <!-- Visibility -->
        <div class="form-group">
          <label for="visibility">Visibility</label>
          <select
            id="visibility"
            v-model="form.visibility"
            class="form-control"
            required
          >
            <option value="public">Public</option>
            <option value="private">Private</option>
          </select>
        </div>
  
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia'
  
  export default {
    props: {
      post: Object,
    },
    data() {
      return {
        form: {
          title: this.post.title || '',
          content: this.post.content || '',
          visibility: this.post.visibility || 'public',
          img: null,
        },
      }
    },
    methods: {
      handleImageUpload(e) {
        this.form.img = e.target.files[0]
      },
      submitForm() {
        const formData = new FormData()
        formData.append('title', this.form.title)
        formData.append('content', this.form.content)
        formData.append('visibility', this.form.visibility)
        if (this.form.img) {
          formData.append('img', this.form.img)
        }
  
        Inertia.post(`/user/dashboard/post/update/${this.post.id}`, formData, {
          forceFormData: true,
          preserveScroll: true,
        })
      },
    },
  }
  </script>
  