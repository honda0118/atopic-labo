<script setup>
import CircularImage from "@/Atoms/Image/CircularImage.vue";
import StarRating from "vue-star-rating";

defineProps({
  product: Object,
});

const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <div v-if="product.reviews.length">
    <p class="mb-2 text-sm text-red-500">1商品につき1回クチコミを投稿できます。</p>
    <ul class="border-t border-gray-300">
      <li
        v-for="user in product.reviews"
        class="border-b border-gray-300"
      >
        <div class="flex justify-between border-b-2 py-2">
          <div class="flex items-center">
            <CircularImage
              class="mr-4"
              :isSmall="true"
              alt="アイコン"
              :src="fileSystemUrl + '/images/icon/' + user.icon"
            />
            <div>
              <span class="mb-1 block">{{ user.name }}</span>
              <StarRating
                class="text-sm"
                v-model:rating="user.pivot.score"
                :increment="1"
                :star-size="18"
                :show-rating="true"
                :read-only="true"
                active-color="orange"
              />
            </div>
          </div>
          <span class="text-sm">{{ user.pivot.created_at }}</span>
        </div>
        <div class="py-2">
          <p class="whitespace-pre-wrap">{{ user.pivot.text }}</p>
        </div>
      </li>
    </ul>
  </div>
</template>
