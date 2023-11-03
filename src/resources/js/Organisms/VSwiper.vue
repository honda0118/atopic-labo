<script setup>
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";
import "swiper/css";
import "swiper/css/free-mode";
import "swiper/css/navigation";
import "swiper/css/thumbs";

defineProps({
  isShowThumbnail: {
    type: Boolean,
    default: false,
  },
  images: Array,
});

const thumbsSwiper = ref(null);

const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
};

/**
 * ・Navigation
 * 画像の切り替えをできるようにする
 * 
 * ・Thumbs
 * サムネイルをクリックした際に、画像の切り替えをできるようにする
 */
const modules = [Navigation, Thumbs];

/**
 * swiper props
 * 
 * ・spaceBetween
 * スライド間の余白を指定（px）
 * 
 * ・navigation
 * 画像を切り替えるボタンを表示・非表示
 * 
 * ・thumbs
 * サムネイルスライダーコンポーネントを指定
 * 
 * ・autoHeight
 * 高さが異なる画像の高さを自動調整する
 * 
 * swiper thumbnail props
 * ・spaceBetween
 * サムネイル間の余白を指定（px）
 * 
 * ・slidesPerView
 * 表示するサムネイル数
 * 
 * ・watchSlidesProgress
 * trueの場合のみ、表示中のサムネイルに「swiper-slide-visible」クラスが付く。
 */
</script>

<template>
  <div>
    <swiper
      :style="{
        '--swiper-navigation-color': 'royalblue',
      }"
      :spaceBetween="10"
      :navigation="true"
      :thumbs="{ swiper: thumbsSwiper }"
      :modules="modules"
      :autoHeight="true"
    >
      <swiper-slide v-for="(image, index) in images" :key="index">
        <img 
          :src="image"
          class="w-full aspect-square"
        />
      </swiper-slide>
    </swiper>
    <swiper
      v-if="isShowThumbnail"
      @swiper="setThumbsSwiper"
      :spaceBetween="10"
      :slidesPerView="3"
      :watchSlidesProgress="true"
      class="my-swiper-thumbnail"
    >
      <swiper-slide v-for="(image, index) in images" :key="index" class="cursor-pointer opacity-100">
        <img 
          :src="image"
          class="w-full aspect-square"
        />
      </swiper-slide>
    </swiper>
  </div>
</template>

<style scoped>
.my-swiper-thumbnail {
  padding: 10px 0;
}
</style>
