<script setup>
import ProductDetail from "@/Organisms/ProductDetail.vue";
import VSwiper from "@/Organisms/VSwiper.vue";
import ReviewList from "@/Organisms/ReviewList.vue";
import TwoColumnLayout from "@/Layouts/TwoColumnLayout.vue";
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  product: Object,
  hasRegisterdLike: Boolean,
  likesNumber: Number,
  hasRegisterdFavorite: Boolean,
  hasRegisterdReview: Boolean,
  avgScore: Number,
});

// image
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;

const images = computed(() => {
  const images = props.product.product_images.map((product_image) => {
    return fileSystemUrl + "/images/product/" + product_image.image;
  });
  return images;
});
</script>

<template>
  <TwoColumnLayout>
    <Head :title="product.name" />
    <main class="hidden p-4 md:block">
      <div class="mx-auto max-w-screen-lg">
        <div class="mb-8 flex items-start">
          <VSwiper :isShowThumbnail="true" :images="images" class="mr-8 w-1/3" />
          <div class="w-2/3">
            <ProductDetail
              :product="product"
              :hasRegisterdLike="hasRegisterdLike"
              :likesNumber="likesNumber"
              :hasRegisterdFavorite="hasRegisterdFavorite"
              :hasRegisterdReview="hasRegisterdReview"
              :avgScore="avgScore"
            />
          </div>
        </div>
        <ReviewList :product="product" />
      </div>
    </main>
    <main class="md:hidden">
      <VSwiper :images="images" />
      <div class="p-4">
        <ProductDetail
          :product="product"
          :hasRegisterdLike="hasRegisterdLike"
          :likesNumber="likesNumber"
          :hasRegisterdFavorite="hasRegisterdFavorite"
          :hasRegisterdReview="hasRegisterdReview"
          :avgScore="avgScore"
          class="mb-8"
        />
        <ReviewList :product="product" />
      </div>
    </main>
  </TwoColumnLayout>
</template>
