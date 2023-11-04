<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import Media from "@/Molecules/Media.vue";
import StarRating from "vue-star-rating";

defineProps({
  products: Array,
});

const onDeletionButtonClicked = (id) => {
};

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <ul class="border-t border-gray-300" v-if="products.length">
    <li v-for="product in products" class="border-b border-gray-300 pt-4">
      <span class="mb-2 block text-gray-500">{{ product.brand.name }}</span>
      <h2 class="border-b-2 pb-2">{{ product.name }}</h2>
      <Media :src="fileSystemUrl + '/images/product/' + product.product_images[0].image" alt="商品">
        <div>
          <StarRating
            v-model:rating="product.pivot.score"
            :increment="0.1"
            :star-size="20"
            :show-rating="true"
            :read-only="true"
            active-color="orange"
            class="mb-6 mr-2 text-sm"
          />
          <p class="mb-2 whitespace-pre-wrap">{{ product.pivot.text }}</p>
          <LinkButton
            :href="route('reviews.edit', { review: product.pivot.id })"
            :isFull="false"
            class="mr-12 bg-red-500 text-sm"
          >
            編集する
          </LinkButton>
          <VButton
            :isFull="false"
            class="bg-indigo-500 text-sm"
            type="button"
            @click="onDeletionButtonClicked(product.pivot.id)"
          >
            削除する
          </VButton>
        </div>
      </Media>
    </li>
  </ul>
  <p v-else>クチコミはありません。</p>
</template>
