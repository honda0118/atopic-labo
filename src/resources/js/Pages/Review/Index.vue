<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import ReviewRegisterList from "@/Organisms/ReviewRegisterList.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  products: Array,
});
</script>

<template>
  <OneColumnLayout heading="投稿クチコミ">
    <Head title="投稿クチコミ" />
    <ReviewRegisterList :products="products" />
  </OneColumnLayout>
</template>
