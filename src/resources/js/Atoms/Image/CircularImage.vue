<script setup>
import { computed } from "vue";

const props = defineProps({
  isSmall: {
    type: Boolean,
    default: false,
  },
  alt: String,
  src: String,
});

const classes = computed(() => {
  if (props.isSmall) {
    return "h-12 w-12";
  }
  return "h-24 w-24";
});
</script>

<template>
  <img class="rounded-full" :class="classes" :alt="alt" :src="src" />
</template>
