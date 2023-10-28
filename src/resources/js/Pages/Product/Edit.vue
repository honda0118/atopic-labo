<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import ProductEditForm from "@/Organisms/ProductEditForm.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  brands: Array,
  categories: Array,
  product: Object,
});
</script>

<template>
  <OneColumnLayout heading="商品編集">
    <Head title="商品編集" />
    <ProductEditForm :brands="brands" :categories="categories" :product="product" />
  </OneColumnLayout>
</template>
