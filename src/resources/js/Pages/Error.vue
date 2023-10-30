<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  status: Number,
});

const title = computed(() => {
  return {
    503: "503: Service Unavailable",
    500: "500: Server Error",
    404: "404: Page Not Found",
    403: "403: Forbidden",
  }[props.status];
});
</script>

<template>
  <OneColumnLayout :heading="title">
    <Head :title="title" />
  </OneColumnLayout>
</template>
