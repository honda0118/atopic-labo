<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import Media from "@/Molecules/Media.vue";
import { router } from "@inertiajs/vue3";
import StarRating from "vue-star-rating";
import { ref } from "vue";

defineProps({
  products: Array,
});

// delete review
const vButtons = ref([]);

const onDeletionButtonClicked = (index, reviewId) => {
  router.delete(route("reviews.destroy", { review: reviewId }), {
    onStart: () => {
      vButtons.value[index].isDisabledExpose = true;
    },
    onFinish: () => {
      if (typeof vButtons.value[index] !== "undefined") {
        vButtons.value[index].isDisabledExpose = false;
      }
    },
  });
};

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <ul
    v-if="products.length"
    class="border-t border-gray-300"
  >
    <li
      v-for="(product, index) in products"
      class="border-b border-gray-300 pt-4"
    >
      <span class="mb-2 block text-gray-500">{{ product.brand.name }}</span>
      <h2 class="border-b-2 pb-2">{{ product.name }}</h2>
      <Media
        :src="fileSystemUrl + '/images/product/' + product.product_images[0].image"
        alt="商品"
      >
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
            class="mr-12 bg-red-500 text-sm"
          >
            編集する
          </LinkButton>
          <VButton
            ref="vButtons"
            class="bg-indigo-500 text-sm"
            type="button"
            @click="onDeletionButtonClicked(index, product.pivot.id)"
          >
            削除する
          </VButton>
        </div>
      </Media>
    </li>
  </ul>
  <p v-else>クチコミはありません。</p>
</template>
