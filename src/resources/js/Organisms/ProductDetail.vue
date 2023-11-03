<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import StarRating from "vue-star-rating";

const props = defineProps({
  product: Object,
  hasRegisterdLike: Boolean,
  likesNumber: Number,
  hasRegisterdFavorite: Boolean,
  hasRegisterdReview: Boolean,
  avgScore: Number,
});

const avgScore = props.avgScore;
</script>

<template>
  <div>
    <span class="mb-2 block text-xl text-gray-500 md:text-2xl">{{ product.brand.name }}</span>
    <h1 class="mb-4 text-2xl md:text-3xl">{{ product.name }}</h1>
    <div class="mb-2 flex items-center">
      <StarRating
        v-model:rating="avgScore"
        :increment="0.1"
        :star-size="30"
        :show-rating="true"
        :read-only="true"
        active-color="orange"
        class="mr-2 text-2xl"
      />
      <span class="text-lg text-gray-600">({{ product.reviews.length }})件</span>
    </div>
    <span class="mb-2 block">{{ product.category.name }}</span>
    <p class="mb-4 whitespace-pre-wrap">{{ product.description }}</p>
    <span class="block">税込価格：{{ product.price_including_tax }}円</span>
    <span class="block">発売日：{{ product.released_at }}</span>
    <span class="mb-4 block">投稿日：{{ product.created_at }}</span>
    <p class="mb-6 text-sm text-red-500">マイページでお気に入りを確認できます。</p>
    <LinkButton v-if="!hasRegisterdReview" :isFull="true" href="" class="bg-red-500">
      クチコミを投稿する
    </LinkButton>
  </div>
</template>
