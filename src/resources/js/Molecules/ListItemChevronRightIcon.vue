<script setup>
import ChevronRightIcon from "@/Atoms/Icon/ChevronRightIcon.vue";
import { computed } from "vue";

const props = defineProps({
  isSmall: {
    type: Boolean,
    default: false,
  },
  nav: String,
});

const classes = computed(() => {
  if (props.isSmall) {
    return "text-sm py-2";
  }
  return "py-4";
});
</script>

<template>
  <li
    :class="classes"
    class="flex items-center justify-between border-b border-gray-300 pl-2 hover:bg-gray-100"
  >
    {{ nav }}
    <ChevronRightIcon />
  </li>
</template>
