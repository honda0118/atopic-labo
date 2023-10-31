<script setup>
import NavListChevronRight from "@/Organisms/NavListChevronRight.vue";
import { computed } from "vue";

const props = defineProps({
  isSmall: {
    type: Boolean,
    default: false,
  },
  brands: Array,
  categories: Array,
});

const formatedCategories = computed(() => {
  return props.categories.map((category) => ({
    id: category.id,
    nav: category.name,
    href: route("categories.products", { category: category.id }),
  }));
});

const formatedBrands = computed(() => {
  return props.brands.map((brand) => ({
    id: brand.id,
    nav: brand.name,
    href: "",
  }));
});
</script>

<template>
  <aside>
    <span class="mb-2 block pl-2 text-lg font-bold">人気カテゴリー</span>
    <NavListChevronRight :isSmall="isSmall" :items="formatedCategories" class="mb-6" />
    <span class="mb-2 block pl-2 text-lg font-bold">人気ブランド</span>
    <NavListChevronRight :isSmall="isSmall" :items="formatedBrands" />
  </aside>
</template>
