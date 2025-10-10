<template>
  <div class="layout">
    <Sidebar
      :routes="routes"
      :activeMenu="activeMenu"
      :csrf="csrf"
    />
    <main class="main-content">
      <slot></slot>
    </main>
  </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";

export default {
  components: { Sidebar },
  props: {
    routes: Object,
    activeMenu: String,
    csrf: String
  }
};
</script>

<style scoped>
.layout {
  display: flex;
  min-height: 100vh;
  background-color: #bcd2ff;
}

.main-content {
  flex: 1;
  padding: 2rem;
  background: #eaf1ff;
  border-radius: 25px 0 0 25px;
  overflow-y: auto;
}
</style>
