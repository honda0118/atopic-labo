<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import ProductRegisterForm from "@/Organisms/ProductRegisterForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  brands: Array,
  categories: Array,
});
</script>

<template>
  <OneColumnLayout heading="商品投稿">
    <Head title="商品投稿" />
    <ProductRegisterForm
      :brands="brands"
      :categories="categories"
    />
  </OneColumnLayout>
</template>
