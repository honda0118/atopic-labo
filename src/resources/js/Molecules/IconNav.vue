<script setup>

defineProps({
  nav: String,
});
</script>

<template>
  <div class="flex flex-col items-center rounded border border-gray-300 bg-white pb-2 pt-4 hover:brightness-90">
    <slot />
    <span class="mt-2 block text-center">{{ nav }}</span>
  </div>
</template>
