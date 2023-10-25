<script setup>
defineProps({
  text: String,
});
</script>

<template>
  <p class="text-sm text-red-500" v-if="text">{{ text }}</p>
</template>
