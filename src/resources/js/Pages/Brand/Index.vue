<script setup>
import SearchFormNavMain from "@/Organisms/SearchFormNavMain.vue";
import NavListChevronRight from "@/Organisms/NavListChevronRight.vue";
import TwoColumnLayout from "@/Layouts/TwoColumnLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  asideBrands: Array,
  asideCategories: Array,
  brands: Array,
});

const formatedBrands = computed(() => {
  return props.brands.map((brand) => ({
    id: brand.id,
    nav: brand.name,
    href: route("brands.products", { brand: brand.id }),
  }));
});
</script>

<template>
  <TwoColumnLayout>
    <Head title="ブランド" />
    <SearchFormNavMain :brands="asideBrands" :categories="asideCategories" heading="ブランド">
      <NavListChevronRight :items="formatedBrands" class="mb-6" />
    </SearchFormNavMain>
  </TwoColumnLayout>
</template>
