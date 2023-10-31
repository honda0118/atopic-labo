<script setup>
import Pagination from "@/Molecules/Pagination.vue";
import SearchFormNavMain from "@/Organisms/SearchFormNavMain.vue";
import ProductMediaList from "@/Organisms/ProductMediaList.vue";
import TwoColumnLayout from "@/Layouts/TwoColumnLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
  isIndexPage: {
    type: Boolean,
    default: false,
  },
  brands: Array,
  categories: Array,
  products: Object,
  heading: String,
  title: String,
});
</script>

<template>
  <TwoColumnLayout>
    <Head :title="title" />
    <img v-if="isIndexPage" class="mx-auto w-full max-w-screen-lg" src="/images/top.png" />
    <SearchFormNavMain
      :brands="brands"
      :categories="categories"
      :heading="heading"
    >
      <ProductMediaList :products="products.data" class="mb-4" />
      <Pagination class="flex justify-center" :links="products.links" />  
    </SearchFormNavMain>
  </TwoColumnLayout>
</template>
