<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import Logo from "@/Atoms/Image/Logo.vue";
import { Link, useForm } from "@inertiajs/vue3";

// form
const form = useForm({});

const onButtonClicked = () => {
  form.post(route("logout"));
};
</script>

<template>
  <header class="hidden md:block">
    <div class="mx-auto flex max-w-screen-lg items-center justify-between border-b px-4 py-4">
      <Link href="/">
        <Logo />
      </Link>
      <div v-if="$page.props.auth.user">
        <Link class="mr-5 text-indigo-600 hover:text-indigo-400" :href="route('mypage')">
          マイページ
        </Link>
        <button
          :disabled="form.processing"
          class="mr-5 text-indigo-600 hover:text-indigo-400"
          @click="onButtonClicked"
        >
          ログアウト
        </button>
        <LinkButton class="bg-red-500 text-sm" :href="route('products.create')">
          商品投稿
        </LinkButton>
      </div>
      <div v-else>
        <Link class="mr-5 text-indigo-600 hover:text-indigo-400" :href="route('login')">
          ログイン
        </Link>
        <Link class="mr-5 text-indigo-600 hover:text-indigo-400" :href="route('register')">
          会員登録
        </Link>
        <LinkButton class="bg-red-500 text-sm" :href="route('products.create')">
          商品投稿
        </LinkButton>
      </div>
    </div>
  </header>
  <header class="md:hidden">
    <div class="mx-auto max-w-screen-lg border-b px-4 pb-2 pt-5">
      <div class="mb-8 flex items-center justify-between">
        <Link href="/">
          <Logo />
        </Link>
        <LinkButton class="bg-red-500 text-sm" :isFull="false" :href="route('products.create')"
          >商品投稿</LinkButton
        >
      </div>
      <div class="flex items-center justify-between">
        <p>Atopic laboにようこそ！</p>
        <div v-if="$page.props.auth.user">
          <Link class="mr-5 text-indigo-600 hover:text-indigo-400" :href="route('mypage')"
            >マイページ</Link
          >
          <button
            :disabled="form.processing"
            class="text-indigo-600 hover:text-indigo-400"
            @click="onButtonClicked"
          >
            ログアウト
          </button>
        </div>
        <div class="text-right" v-else>
          <Link class="mr-5 text-indigo-600 hover:text-indigo-400" :href="route('login')"
            >ログイン</Link
          >
          <Link class="text-indigo-600 hover:text-indigo-400" :href="route('register')"
            >会員登録</Link
          >
        </div>
      </div>
    </div>
  </header>
</template>
