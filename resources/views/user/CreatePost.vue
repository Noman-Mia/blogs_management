<template>
    <div class="container mt-4">
      <h2>Create a New Post</h2>
  
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <!-- Title -->
        <div class="form-group">
          <label for="title">Title</label>
          <input v-model="form.title" type="text" class="form-control" id="title" required />
        </div>
  
        <!-- Content -->
        <div class="form-group">
          <label for="content">Content</label>
          <textarea v-model="form.content" class="form-control" id="content" rows="4" required></textarea>
        </div>
  
        <!-- Image -->
        <div class="form-group">
          <label for="img">Image</label>
          <input @change="handleImageUpload" type="file" class="form-control-file" id="img" name="img" accept="image/*" />
        </div>
  
        <!-- Visibility -->
        <div class="form-group">
          <label for="visibility">Visibility</label>
          <select v-model="form.visibility" class="form-control" id="visibility" required>
            <option value="public" selected>Public</option>
            <option value="private">Private</option>
          </select>
        </div>
  
        <!-- Tags -->
        <div class="form-group">
          <label for="tags">Tags (comma separated)</label>
          <input v-model="form.tags" type="text" name="tags" id="tags" class="form-control" placeholder="e.g. Laravel, Vue, PHP" />
        </div>
  
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Create Post</button>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from "@inertiajs/inertia";
  
  export default {
    data() {
      return {
        form: {
          title: "",
          content: "",
          img: null,
          visibility: "public",
          tags: "",
        },
      };
    },
    methods: {
      handleImageUpload(event) {
        this.form.img = event.target.files[0];
      },
      submitForm() {
        const formData = new FormData();
        formData.append("title", this.form.title);
        formData.append("content", this.form.content);
        formData.append("img", this.form.img);
        formData.append("visibility", this.form.visibility);
        formData.append("tags", this.form.tags);
  
        Inertia.post("/post/store", formData);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any additional styles here */
  </style>
  