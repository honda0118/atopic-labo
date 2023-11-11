<script setup>
import Media from "@/Molecules/Media.vue";
import { Link } from "@inertiajs/vue3";
import StarRating from "vue-star-rating";

defineProps({
  products: Array,
  isShowRanking: {
    type: Boolean,
    default: false,
  },
});

const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <ul
    v-if="products.length"
    class="border-t border-gray-300"
  >
    <li
      v-for="(product, index) in products"
      :key="product.id"
      class="border-b border-gray-300 pt-4"
    >
      <Link :href="route('products.show', { product: product.id })">
        <span class="mb-2 block text-gray-500">{{ product.brand.name }}</span>
        <h2 class="border-b-2 pb-2">{{ product.name }}</h2>
        <Media
          :src="fileSystemUrl + '/images/product/' + product.product_images[0].image"
          alt="商品"
        >
          <div class="text-sm">
            <span
              v-if="isShowRanking"
              class="block text-2xl font-bold text-red-500"
            >
              #{{ index + 1 }}
            </span>
            <div class="mb-2 flex items-center">
              <StarRating
                v-model:rating="product.avg_score"
                :increment="0.1"
                :star-size="20"
                :show-rating="true"
                :read-only="true"
                active-color="orange"
                class="mr-2"
              />
              <span class="text-gray-600">({{ product.reviews.length }})件</span>
            </div>
            <span class="mb-2 block">{{ product.category.name }}</span>
            <span class="block">税込価格：{{ product.price_including_tax }}円</span>
            <span class="block">投稿日：{{ product.save_interval }}</span>
          </div>
        </Media>
      </Link>
    </li>
  </ul>
  <p v-else>商品はありません。</p>
</template>
