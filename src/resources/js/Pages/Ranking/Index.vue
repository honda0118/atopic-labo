<script setup>
import ProductMediaList from "@/Organisms/ProductMediaList.vue";
import SearchFormNavMain from "@/Organisms/SearchFormNavMain.vue";
import TwoColumnLayout from "@/Layouts/TwoColumnLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  brands: Array,
  categories: Array,
  heading: String,
  products: Array,
  title: String,
});
</script>

<template>
  <TwoColumnLayout>
    <Head :title="title" />
    <SearchFormNavMain :brands="brands" :categories="categories" :heading="heading">
      <ProductMediaList :products="products" :isShowRanking="true" />
    </SearchFormNavMain>
  </TwoColumnLayout>
</template>
