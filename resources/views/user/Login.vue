<template>
    <div class="container">
      <br>
      <!-- Display Success Message -->
      <div v-if="successMessage" class="alert alert-success">
        {{ successMessage }}
      </div>
  
      <!-- Display Error Message -->
      <div v-if="errorMessage" class="alert alert-danger">
        {{ errorMessage }}
      </div>
  
      <h2>Login</h2>
  
      <!-- Login Form -->
      <form @submit.prevent="submitForm">
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
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  

  export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
        successMessage: null,
        errorMessage: null,
      };
    },
    methods: {
      submitForm() {
        this.errorMessage = null; // Clear previous error messages
        Inertia.post('/user/check', this.form, {
          onSuccess: (response) => {
            if (response.props.success) {
              this.successMessage = response.props.success; // Show success message
            }
          },
          onError: (errors) => {
            if (errors) {
              this.errorMessage = errors[0]; // Display the first error message
            }
          },
        });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Optional custom styles */
  </style>
  