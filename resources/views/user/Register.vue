<template>
    <div class="container">
      <br><br>
      <h2>Register</h2>
  
      <!-- Success message -->
      <div v-if="successMessage" class="alert alert-success">
        {{ successMessage }}
      </div>
  
      <!-- Error messages -->
      <div v-if="errors.length" class="alert alert-danger">
        <ul class="mb-0">
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>
  
      <form @submit.prevent="submitForm" enctype="multipart/form-data">
        <div class="form-group">
          <label for="name">Name</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            class="form-control"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            class="form-control"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            class="form-control"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <input
            type="password"
            id="password_confirmation"
            v-model="form.password_confirmation"
            class="form-control"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="img">Profile Picture</label>
          <input
            type="file"
            class="form-control-file"
            id="img"
            @change="handleFileChange"
            accept="image/*"
          />
        </div>
  
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  
  export default {
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: '',
          password_confirmation: '',
          img: null,
        },
        errors: [],
        successMessage: null,
      };
    },
    methods: {
      handleFileChange(event) {
        this.form.img = event.target.files[0];
      },
      submitForm() {
        this.errors = []; // Reset errors on submit
        Inertia.post('/user/save', this.form, {
          onSuccess: () => {
            this.successMessage = 'User Created Successfully, Please Login';
          },
          onError: (errors) => {
            this.errors = Object.values(errors); // Handle validation errors
          },
        });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add custom styles here if needed */
  </style>
  