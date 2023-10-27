<script setup>
import CircularImage from "@/Atoms/Image/CircularImage.vue";
import ListItemChevronRightIcon from "@/Molecules/ListItemChevronRightIcon.vue";
import NavListChevronRight from "@/Organisms/NavListChevronRight.vue";
import UserDeletionModal from "@/Organisms/UserDeletionModal.vue";
import { useModal } from "@/Composable/Modal";
import { usePage } from "@inertiajs/vue3";
import { computed, onUnmounted, watchEffect } from "vue";
import { useFlashMessageStore } from "@/stores/flashMessage";

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
    href: route("profile.edit"),
    nav: "プロフィールを編集する",
  },
  {
    href: route("profile.password.edit"),
    nav: "パスワードを編集する",
  },
];

// easy login user items
// かんたんログイン機能でログインした会員は、会員メニューを利用することができない
const easyLoginUserItems = [
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

// flash message
let timeoutId = 0;
const flashMessageStore = useFlashMessageStore();

onUnmounted(() => {
  flashMessageStore.setIsShow(false);
  clearTimeout(timeoutId);
});

// バックエンドから取得したメッセージを10秒間表示する
watchEffect(() => {
  if (flashMessageStore.isShow) {
    timeoutId = setTimeout(() => {
      flashMessageStore.setIsShow(false);
    }, 10000);
  }
});

// modal
const { isOpen } = useModal();

const onItemClicked = () => {
  if (isEasyLoginUser.value) {
    return;
  }
  isOpen.value = true;
};

const close = () => {
  isOpen.value = false;
};
</script>

<template>
  <UserDeletionModal @close="close" :isOpen="isOpen" />
  <div>
    <div class="mb-14 flex flex-col text-center">
      <CircularImage
        :src="fileSystemUrl + '/images/icon/' + $page.props.auth.user.icon"
        alt="アイコン"
        class="mx-auto mb-2"
      />
      <span class="mb-4">{{ $page.props.auth.user.name }}</span>
      <p>お肌にやさしい商品を投稿しませんか？</p>
      <div v-if="flashMessageStore.isShow" class="relative">
        <p class="absolute top-2 w-full rounded bg-red-500 py-2 text-white">
          {{ $page.props.flash.message }}
        </p>
      </div>
    </div>
    <h2 class="mb-4 ml-2 text-xl font-black">商品</h2>
    <NavListChevronRight :items="productItems" class="mb-8" />
    <h2 class="mb-4 ml-2 text-xl font-black">会員</h2>
    <NavListChevronRight v-if="isEasyLoginUser" :items="easyLoginUserItems" />
    <NavListChevronRight v-else :items="userItems" />
    <ul class="mb-4 cursor-pointer" @click="onItemClicked">
      <ListItemChevronRightIcon nav="退会する" />
    </ul>
    <p v-if="isEasyLoginUser" class="text-red-500" >
      かんたんログイン機能でログインした会員は、会員メニューを利用することができません。
    </p>
  </div>
</template>
