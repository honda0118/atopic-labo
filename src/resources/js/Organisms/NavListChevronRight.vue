<script setup>
import ListItemChevronRightIcon from "@/Molecules/ListItemChevronRightIcon.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
  items: Array,
  isSmall: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <ul
    v-if="items.length"
    class="border-t border-gray-300"
  >
    <Link
      v-for="item in items"
      :key="item.href"
      :href="item.href"
    >
      <ListItemChevronRightIcon
        :isSmall="isSmall"
        :nav="item.nav"
      />
    </Link>
  </ul>
</template>
