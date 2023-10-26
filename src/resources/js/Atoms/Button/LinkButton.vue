<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  isFull: {
    type: Boolean,
    default: false,
  },
  href: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Link
    :class="{ 'w-full': isFull }"
    :href="href"
    class="inline-block rounded px-3 py-2 text-center text-lg font-bold text-white hover:brightness-90"
  >
    <slot />
  </Link>
</template>
