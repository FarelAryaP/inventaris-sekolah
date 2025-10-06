<template>
<div class="body">
  <div class="form-login">

    <div class="text-center">
      <h3>Login Siswa</h3>
      <p>Sistem Inventaris Sekolah</p>
    </div>

    <!-- Error dari backend -->
    <div v-if="error" class="alert alert-danger">
      {{ error }}
    </div>

    <!-- Login Form -->
  <form @submit.prevent="submitForm">
      <div class="input-data">
        <label for="nisn" class="form-label">NISN</label>
        <input type="text" class="form-control" id="nisn" v-model="nisn" required autofocus />
      </div>

    <div class="input-data">
      <label for="password" class="form-label">Password</label>
      <input :type="showPassword ? 'text' : 'password'" class="form-control" id="password" v-model="password" required />

      <small @click="showPassword = !showPassword">
        {{ showPassword ? 'Sembunyikan' : 'Tampilkan' }} Password
      </small>
    </div>

      <button type="submit" class="btn-login">Login</button>
  </form>

    <div class="text-center">
      <a href="/admin/login" class="text-muted">Login sebagai Admin</a>
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

axios.defaults.headers.common['X-CSRF-TOKEN'] =
    document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export default {
  data() {
    return {
      nisn: "",
      password: "",
      showPassword: false,
      error: null,
    };
  },
  methods: {
    async submitForm() {
  try {
    let res = await axios.post("/login", {
      nisn: this.nisn,
      password: this.password,
    });

    if (res.data.success) {
      window.location.href = res.data.redirect || "/user.dashboard";
    }
  } catch (err) {
    this.error = err.response?.data?.message || "Login gagal";
  }
  }
 },
};
</script>