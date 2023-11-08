<script setup>
import SearchFormNavMain from "@/Organisms/SearchFormNavMain.vue";
import NavListChevronRight from "@/Organisms/NavListChevronRight.vue";
import TwoColumnLayout from "@/Layouts/TwoColumnLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  asideBrands: Array,
  asideCategories: Array,
  categories: Array,
});

const formatedCategories = computed(() => {
  return props.categories.map((category) => ({
    id: category.id,
    nav: category.name,
    href: route("categories.products", { category: category.id }),
  }));
});
</script>

<template>
  <TwoColumnLayout>
    <Head title="カテゴリー" />
    <SearchFormNavMain
      :brands="asideBrands"
      :categories="asideCategories"
      heading="カテゴリー"
    >
      <NavListChevronRight
        :items="formatedCategories"
        class="mb-6"
      />
    </SearchFormNavMain>
  </TwoColumnLayout>
</template>
