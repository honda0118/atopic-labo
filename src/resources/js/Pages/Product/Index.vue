<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import ProductMediaRegisterList from "@/Organisms/ProductMediaRegisterList.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  products: Array,
});
</script>

<template>
  <OneColumnLayout heading="投稿商品">
    <Head title="投稿商品" />
    <ProductMediaRegisterList :products="products" />
  </OneColumnLayout>
</template>
