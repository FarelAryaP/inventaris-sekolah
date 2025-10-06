<template>
  <nav class="navbar">
    <a class="navbar-brand" href="/user/dashboard">Portal Siswa</a>
    <button
      class="nav-btn"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"></button>

    <div class="nav-section" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/user/dashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/user/pengajuan">Pengajuan Saya</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/user/pengajuan/create">Ajukan Barang</a>
        </li>
      </ul>

      <div class="navbar-nav">
        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown">
          {{ user.nama }}
        </a>
        <ul class="nav-menu">
          <li>
            <span class="item-text">NISN: {{ user.nisn }}</span>
          </li>
          <li>
            <span class="item-text">Kelas: {{ user.kelas }}</span>
          </li>
          <li>
            <form @submit.prevent="logout">
              <button type="submit" class="btn-out">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="container-fluid mt-4">
    <div
      v-if="successMessage"
      class="alert alert-success alert-dismissible fade show"
      role="alert"
    >
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div
      v-if="errorMessage"
      class="alert alert-danger alert-dismissible fade show"
      role="alert"
    >
      {{ errorMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <div
      v-if="errors.length"
      class="alert alert-danger alert-dismissible fade show"
      role="alert"
    >
      <ul class="mb-0">
        <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <slot />
  </div>
</template>

<script>
export default {
  props: {
    // bisa dioper dari parent / API
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      successMessage: null,
      errorMessage: null,
      errors: [],
    };
  },
  methods: {
    logout() {
      // sesuaikan dengan endpoint logout Laravel
      fetch("/logout", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
        },
      }).then(() => {
        window.location.href = "/login";
      });
    },
  },
};
</script>
