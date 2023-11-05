<script setup>
import ReviewEditForm from "@/Organisms/ReviewEditForm.vue";
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  product: Object,
});
</script>

<template>
  <OneColumnLayout heading="クチコミ編集">
    <Head title="クチコミ編集" />
    <ReviewEditForm :product="product" />
  </OneColumnLayout>
</template>
