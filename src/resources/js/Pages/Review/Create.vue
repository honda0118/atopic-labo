<script setup>
import ReviewRegisterForm from "@/Organisms/ReviewRegisterForm.vue";
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  product: Object,
});
</script>

<template>
  <OneColumnLayout heading="クチコミ投稿">
    <Head title="クチコミ投稿" />
    <ReviewRegisterForm :product="product" />
  </OneColumnLayout>
</template>
