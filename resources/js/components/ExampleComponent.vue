<script setup>
defineProps({
  user: Object
})
</script>

<template>
  <div>
    <slot></slot>
    <p>Nama: {{ user.nama }}</p>
    <p>Email: {{ user.email }}</p>
  </div>
</template>

