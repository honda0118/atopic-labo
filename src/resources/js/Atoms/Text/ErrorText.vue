<script setup>
defineProps({
  text: String,
});
</script>

<template>
  <p
    v-if="text"
    class="text-sm text-red-500"
  >
    {{ text }}
  </p>
</template>
