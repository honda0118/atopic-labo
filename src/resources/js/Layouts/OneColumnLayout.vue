<script setup>
import OneColumnLayoutHeader from "@/Organisms/OneColumnLayoutHeader.vue";
import VFooter from "@/Organisms/VFooter.vue";

defineProps({
  heading: String,
});
</script>

<template>
  <OneColumnLayoutHeader />
  <main class="mx-auto max-w-screen-sm px-4 py-8">
    <h1 class="mb-6 text-center text-2xl font-bold">{{ heading }}</h1>
    <slot />
  </main>
  <VFooter />
</template>
