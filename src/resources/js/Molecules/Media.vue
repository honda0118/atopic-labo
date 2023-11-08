<script setup>
defineProps({
  alt: String,
  src: String,
});
</script>

<template>
  <div class="flex pb-6 pt-4">
    <img
      :alt="alt"
      :src="src"
      class="mr-4 h-28 w-28"
    />
    <slot />
  </div>
</template>
