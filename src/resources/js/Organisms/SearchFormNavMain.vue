<script setup>
import SearchForm from "@/Molecules/SearchForm.vue";
import IconNavList from "@/Organisms/IconNavList.vue";
import VAside from "@/Organisms/VAside.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  brands: Array,
  categories: Array,
  heading: String,
});

// form
const form = useForm({
  keyword: "",
});

const onSubmit = () => {
  form.get(route("search.index", { keyword: form.keyword }));
};
</script>

<template>
  <div>
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
          <slot />
        </main>
      </div>
    </div>
    <div class="mx-auto max-w-screen-lg px-4 pb-8 pt-4 md:hidden">
      <main class="mb-8">
        <h1 class="mb-2 text-lg font-bold">{{ heading }}</h1>
        <slot />
      </main>
      <VAside :categories="categories" :brands="brands" />
    </div>
  </div>
</template>
