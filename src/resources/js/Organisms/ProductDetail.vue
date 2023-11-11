<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import HearIcon from "@/Atoms/Icon/HeartIcon.vue";
import LikeIcon from "@/Atoms/Icon/LikeIcon.vue";
import IconButton from "@/Molecules/IconButton.vue";
import StarRating from "vue-star-rating";
import { router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  product: Object,
  likesNumber: Number,
  hasRegisterdLike: Boolean,
  hasRegisterdFavorite: Boolean,
  hasRegisterdReview: Boolean,
  avgScore: Number,
});

const avgScore = props.product.avg_score;

// api
const HTTP_STATUS_CREATED = 201;
const HTTP_STATUS_UNAUTHORIZED = 401;
const isProcessing = ref(false);

// like
const isFullLikeIcon = ref(props.hasRegisterdLike);
const number = ref(props.likesNumber);

const onLikeButtonClicked = async () => {
  try {
    isProcessing.value = true;
    const response = await axios.post(route("likes.switch", { product: props.product.id }));

    if (response.status === HTTP_STATUS_CREATED) {
      isFullLikeIcon.value = true;
    } else {
      isFullLikeIcon.value = false;
    }
    number.value = response.data.likesNumber;
  } catch (e) {
    toOtherPage(e);
  } finally {
    isProcessing.value = false;
  }
};

// favorite
const isFullFavoriteIcon = ref(props.hasRegisterdFavorite);

const onFavoriteButtonClicked = async () => {
  try {
    isProcessing.value = true;
    const response = await axios.post(route("favorites.switch", { product: props.product.id }));

    if (response.status === HTTP_STATUS_CREATED) {
      isFullFavoriteIcon.value = true;
    } else {
      isFullFavoriteIcon.value = false;
    }
  } catch (e) {
    toOtherPage(e);
  } finally {
    isProcessing.value = false;
  }
};

const toOtherPage = (e) => {
  if (e.response.status === HTTP_STATUS_UNAUTHORIZED) {
    router.get(route("login"));
  } else {
    router.get("/");
  }
};

// purchase site button 
const onPurchaseSiteButtonClicked = () => {
  window.location = props.product.purchase_site;
};
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
    <span class="mb-4 block">投稿日：{{ product.created_at }}</span>
    <div class="mb-2">
      <IconButton
        :isDisabled="isProcessing"
        class="mr-4"
        @click="onFavoriteButtonClicked"
      >
        <template v-slot:icon>
          <HearIcon :isFull="isFullFavoriteIcon" />
        </template>
        お気に入りに登録する
      </IconButton>
      <IconButton
        :isDisabled="isProcessing"
        @click="onLikeButtonClicked"
      >
        <template v-slot:icon>
          <LikeIcon :isFull="isFullLikeIcon" />
        </template>
        {{ number }}
      </IconButton>
    </div>
    <p class="mb-6 text-sm text-red-500">マイページでお気に入りを確認できます。</p>
    <VButton
      :isFull="true"
      class="mb-6 bg-indigo-500"
      @click="onPurchaseSiteButtonClicked"
    >
      購入サイトへ
    </VButton>
    <LinkButton
      v-if="!hasRegisterdReview"
      :isFull="true"
      :href="route('reviews.create', { product_id: product.id })"
      class="bg-red-500"
    >
      クチコミを投稿する
    </LinkButton>
  </div>
</template>
