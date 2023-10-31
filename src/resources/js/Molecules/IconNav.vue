<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  href: {
    type: String,
    required: true,
  },
  nav: String,
});
</script>

<template>
  <Link class="rounded border border-gray-300 bg-white pb-2 pt-4 hover:brightness-90" :href="href">
    <slot />
    <span class="mt-2 block text-center">{{ nav }}</span>
  </Link>
</template>
