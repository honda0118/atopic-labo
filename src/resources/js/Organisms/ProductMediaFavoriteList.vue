<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import Media from "@/Molecules/Media.vue";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
  products: Array,
});

// delete favorite
const vButtons = ref([]);

const onDeletionButtonClicked = (index, favoriteId) => {
  router.delete(route("favorites.destroy", { favorite: favoriteId }), {
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
        <div class="flex flex-col">
          <LinkButton
            :isFull="true"
            :href="route('products.show', { product: product.id })"
            class="mb-4 mr-12 bg-red-500 text-sm"
          >
            商品詳細へ
          </LinkButton>
          <VButton
            ref="vButtons"
            class="bg-indigo-500 text-sm"
            type="button"
            @click="onDeletionButtonClicked(index, product.pivot.id)"
          >
            お気に入りから削除する
          </VButton>
        </div>
      </Media>
    </li>
  </ul>
  <p v-else>商品はありません。</p>
</template>
