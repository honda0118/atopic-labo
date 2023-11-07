<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import ProductMediaFavoriteList from "@/Organisms/ProductMediaFavoriteList.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  products: Array,
});
</script>

<template>
  <OneColumnLayout heading="お気に入り商品">
    <Head title="お気に入り商品" />
    <ProductMediaFavoriteList :products="products" />
  </OneColumnLayout>
</template>
