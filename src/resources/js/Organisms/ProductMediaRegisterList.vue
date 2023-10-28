<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import Media from "@/Molecules/Media.vue";

defineProps({
  products: Array,
});

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <ul class="border-t border-gray-300" v-if="products.length">
    <li v-for="product in products" class="border-b border-gray-300 pt-4">
      <span class="mb-2 block text-gray-500">{{ product.brand.name }}</span>
      <h2 class="border-b-2 pb-2">{{ product.name }}</h2>
      <Media :src="fileSystemUrl + '/images/product/' + product.product_images[0].image" alt="商品">
        <div class="text-sm">
          <span class="mb-2 block">{{ product.category.name }}</span>
          <p class="mb-2 whitespace-pre-wrap">{{ product.description }}</p>
          <span class="mb-1 block">税込価格：{{ product.price_including_tax }}円</span>
          <span class="mb-1 block">発売日：{{ product.released_at }}</span>
          <span class="mb-2 block">投稿日：{{ product.formated_created_at }}</span>
          <LinkButton
            :href="route('products.edit', { product: product.id })"
            class="mr-12 bg-red-500 text-sm"
          >
            編集する
          </LinkButton>
          <VButton class="bg-indigo-500 text-sm" type="button">
            削除する
          </VButton>
        </div>
      </Media>
    </li>
  </ul>
  <p v-else>商品はありません。</p>
</template>
