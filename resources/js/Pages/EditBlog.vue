<template>
  <div class="container mt-5">
    <h2>Edit Blog</h2>
    <form @submit.prevent="submitForm" class="mt-4">

      <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" v-model="form.title" />
        <span class="text-danger" v-if="form.errors.title">{{ form.errors.title }}</span>
      </div>

      <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea class="form-control" rows="6" v-model="form.content"></textarea>
        <span class="text-danger" v-if="form.errors.content">{{ form.errors.content }}</span>
      </div>

      <div class="mb-3">
        <label class="form-label">Visibility</label>
        <select class="form-select" v-model="form.visibility">
          <option value="public">Public</option>
          <option value="private">Private</option>
        </select>
        <span class="text-danger" v-if="form.errors.visibility">{{ form.errors.visibility }}</span>
      </div>

      <div class="mb-3">
        <label class="form-label">Replace Image</label>
        <input type="file" class="form-control" @change="handleImageUpload" />
        <span class="text-danger" v-if="form.errors.image">{{ form.errors.image }}</span>
      </div>

      <button type="submit" class="btn btn-primary">Update Blog</button>
    </form>
  </div>
</template>

<script setup>
import { useForm, router } from "@inertiajs/vue3";
const props = defineProps({ post: Object });

const form = useForm({
  title: props.post.title,
  content: props.post.content,
  visibility: props.post.visibility,
  image: null,
});

const handleImageUpload = (e) => {
  form.image = e.target.files[0];
};

const submitForm = () => {
  router.post(`/update/${props.post.id}`, {
    _method: 'put',
    ...form
  }, {
    onSuccess: () => {
      alert("Blog updated successfully!");
      router.visit('/ShowBlogs');
    }
  });
};
</script>
