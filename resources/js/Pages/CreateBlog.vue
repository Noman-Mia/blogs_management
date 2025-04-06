<template>
  <div class="container mt-5">
    <h2 class="mb-4 text-primary">Create New Blog</h2>

    <!-- Success message -->
    <div v-if="$page.props.flash.success" class="alert alert-success">
      {{ $page.props.flash.success }}
    </div>

    <div class="card shadow">
      <div class="card-body">
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
          <!-- Title -->
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input v-model="form.title" type="text" class="form-control" />
            <div v-if="form.errors.title" class="text-danger">{{ form.errors.title }}</div>
          </div>

          <!-- Content -->
          <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea v-model="form.content" class="form-control" rows="5"></textarea>
            <div v-if="form.errors.content" class="text-danger">{{ form.errors.content }}</div>
          </div>

          <!-- Visibility -->
          <div class="mb-3">
            <label class="form-label">Visibility</label>
            <select v-model="form.visibility" class="form-select">
              <option value="public">Public</option>
              <option value="private">Private</option>
            </select>
            <div v-if="form.errors.visibility" class="text-danger">{{ form.errors.visibility }}</div>
          </div>

          <!-- Image -->
          <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" class="form-control" @change="handleImage" />
            <div v-if="form.errors.image" class="text-danger">{{ form.errors.image }}</div>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-primary">Publish Blog</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  title: '',
  content: '',
  visibility: 'public',
  image: null,
})

const handleImage = (e) => {
  form.image = e.target.files[0]
}

const submitForm = () => {
  form.post('/CreateBlog', {
    forceFormData: true,
    preserveScroll: true,
  })
}
</script>

<style scoped>
textarea {
  resize: vertical;
}
</style>
