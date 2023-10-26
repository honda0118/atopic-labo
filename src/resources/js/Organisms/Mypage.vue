<script setup>
import CircularImage from "@/Atoms/Image/CircularImage.vue";
import ListItemChevronRightIcon from "@/Molecules/ListItemChevronRightIcon.vue";
import NavListChevronRight from "@/Organisms/NavListChevronRight.vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

// product items
const productItems = [
  {
    href: route("mypage"),
    nav: "商品を投稿する",
  },
  {
    href: route("mypage"),
    nav: "投稿した商品",
  },
  {
    href: route("mypage"),
    nav: "お気に入り商品",
  },
  {
    href: route("mypage"),
    nav: "投稿したクチコミ",
  },
];

// user items
const userItems = [
  {
    href: route("mypage"),
    nav: "プロフィールを編集する",
  },
  {
    href: route("mypage"),
    nav: "パスワードを編集する",
  },
];

// かんたんログイン機能でログインした会員は、会員メニューを利用することができない
const userItemsForEasyLogin = [
  {
    href: route("mypage"),
    nav: "プロフィールを編集する",
  },
  {
    href: route("mypage"),
    nav: "パスワードを編集する",
  },
];

// easy login user id
const EASY_LOGIN_USER_ID = 1;
const page = usePage();

const isEasyLoginUser = computed(() => {
  if (page.props.auth.user.id === EASY_LOGIN_USER_ID) {
    return true;
  }
  return false;
});

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <div>
    <div class="mb-12 flex flex-col text-center">
      <CircularImage
        :src="fileSystemUrl + '/images/icon/' + $page.props.auth.user.icon"
        alt="アイコン"
        class="mx-auto mb-2"
      />
      <span class="mb-4">{{ $page.props.auth.user.name }}</span>
      <p class="mb-4">お肌にやさしい商品を投稿しませんか？</p>
    </div>
    <h2 class="mb-4 ml-2 text-xl font-black">商品</h2>
    <NavListChevronRight :items="productItems" class="mb-8" />
    <h2 class="mb-4 ml-2 text-xl font-black">会員</h2>
    <NavListChevronRight v-if="isEasyLoginUser" :items="userItemsForEasyLogin" />
    <NavListChevronRight v-else :items="userItems" />
    <ul class="mb-4 cursor-pointer" @click="onItemClicked">
      <ListItemChevronRightIcon nav="退会する" />
    </ul>
    <p class="text-red-500" v-if="isEasyLoginUser">
      かんたんログイン機能でログインした会員は、会員メニューを利用することができません。
    </p>
  </div>
</template>
