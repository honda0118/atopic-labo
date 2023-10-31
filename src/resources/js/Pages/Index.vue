<script setup>
import Pagination from "@/Molecules/Pagination.vue";
import SearchForm from "@/Molecules/SearchForm.vue";
import IconNavList from "@/Organisms/IconNavList.vue";
import ProductMediaList from "@/Organisms/ProductMediaList.vue";
import VAside from "@/Organisms/VAside.vue";
import TwoColumnLayout from "@/Layouts/TwoColumnLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
  isIndexPage: {
    type: Boolean,
    default: false,
  },
  brands: Array,
  categories: Array,
  heading: String,
  products: Object,
  title: String,
});

// form
const form = useForm({
  keyword: "",
});

const onSubmit = () => {
};
</script>

<template>
  <TwoColumnLayout>
    <Head :title="title" />
    <img v-if="isIndexPage" class="mx-auto w-full max-w-screen-lg" src="/images/top.png" />
    <div class="mx-auto max-w-screen-lg bg-gray-100 p-4">
      <form class="mb-6" @submit.prevent="onSubmit">
        <SearchForm v-model:keyword="form.keyword" class="mx-auto max-w-2xl" placeholder="例）ブランド・商品・キーワード" />
      </form>
      <IconNavList />
    </div>
    <div class="mx-auto hidden max-w-screen-lg md:block">
      <div class="flex px-4 pb-8 pt-4">
        <VAside :isSmall="true" :categories="categories" :brands="brands" class="mr-10 w-1/4" />
        <main class="w-3/4">
          <h1 class="mb-2 text-lg font-bold">{{ heading }}</h1>
          <ProductMediaList :products="products.data" class="mb-4" />
          <Pagination class="flex justify-center" :links="products.links" />
        </main>
      </div>
    </div>
    <div class="mx-auto max-w-screen-lg px-4 pb-8 pt-4 md:hidden">
      <main class="mb-8">
        <h1 class="mb-2 text-lg font-bold">{{ heading }}</h1>
        <ProductMediaList :products="products.data" class="mb-4" />
        <Pagination class="flex justify-center" :links="products.links" />
      </main>
      <VAside :categories="categories" :brands="brands" />
    </div>
  </TwoColumnLayout>
</template>
