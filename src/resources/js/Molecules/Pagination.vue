<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
  links: Array,
});
</script>

<template>
  <div v-if="links.length > 3">
    <div class="-mb-1 flex flex-wrap">
      <template
        v-for="(link, p) in links"
        :key="p"
      >
        <div
          v-if="link.url === null"
          class="mb-1 mr-1 rounded border px-4 py-3 text-sm leading-4 text-gray-400"
          v-html="link.label"
        />
        <Link
          v-else
          class="mb-1 mr-1 rounded border px-4 py-3 text-sm leading-4 hover:brightness-90 focus:border-indigo-500 focus:text-indigo-500"
          :class="{ 'bg-blue-700 text-white': link.active }"
          :href="link.url"
          v-html="link.label"
        />
      </template>
    </div>
  </div>
</template>
