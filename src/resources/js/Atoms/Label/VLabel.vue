<script setup>
defineProps({
  for: String,
});
</script>

<template>
  <label class="block font-bold text-gray-700" :for="for">
    <slot />
  </label>
</template>
