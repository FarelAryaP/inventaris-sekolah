<template>
  <div class="body">
    <div class="form-login">
      <div class="text-center">
        <h3>Login Admin</h3>
        <p>Sistem Inventaris Sekolah</p>
      </div>

      <!-- Error dari backend -->
      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <!-- Login Form -->
      <form @submit.prevent="submitForm">
        <div class="input-data">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control"
              id="username"
              v-model="username" required />
        </div>

        <div class="input-data">
          <label for="password" class="form-label">Password</label>
          <input
            :type="showPassword ? 'text' : 'password'"
            class="form-control"
            id="password"
            v-model="password"
            required />

          <small @click="showPassword = !showPassword" style="cursor: pointer;">
            {{ showPassword ? "Sembunyikan" : "Tampilkan" }} Password
          </small>
        </div>

        <button type="submit" class="btn-login">Login</button>
      </form>

      <div class="text-center">
        <a href="/login" class="text-muted">Login sebagai Siswa</a>
      </div>
    </div>
  </div>

  <div class="simon">
    <div class="eyes"></div>
    <div class="mouth"></div>
    <ul class="tentacles">
      <div class="leg"></div>
      <div class="leg"></div>
      <div class="leg"></div>
      <div class="leg"></div>
    </ul>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      username: "",
      password: "",
      showPassword: false,
      error: null,
    };
  },
  methods: {
    async submitForm() {
      try {
        const token = document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute("content");

        const response = await axios.post("/admin/login", {
            username: this.username,
            password: this.password,
          },
          {
            headers: {
              "X-CSRF-TOKEN": token,
              "Content-Type": "application/json",
            },
            withCredentials: true, // ⬅️ penting agar session Laravel tersimpan
          }
        );

        if (response.data.success) {
          window.location.href = response.data.redirect || "/admin/dashboard";
        }
      } catch (err) {
        this.error =
          err.response?.data?.message || "Login gagal. Periksa kembali data.";
      }
    },
  },
};
</script>