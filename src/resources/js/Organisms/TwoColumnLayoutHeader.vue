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
        <Link
          :href="route('mypage')"
          class="mr-5 text-indigo-600 hover:text-indigo-400"
        >
          マイページ
        </Link>
        <button
          :disabled="form.processing"
          class="mr-5 text-indigo-600 hover:text-indigo-400"
          @click="onButtonClicked"
        >
          ログアウト
        </button>
        <LinkButton
          :href="route('products.create')"
          class="bg-red-500 text-sm"
        >
          商品投稿
        </LinkButton>
      </div>
      <div v-else>
        <Link
          :href="route('login')"
          class="mr-5 text-indigo-600 hover:text-indigo-400"
        >
          ログイン
        </Link>
        <Link
          :href="route('register')"
          class="mr-5 text-indigo-600 hover:text-indigo-400"
        >
          会員登録
        </Link>
        <LinkButton
          :href="route('products.create')"
          class="bg-red-500 text-sm"
        >
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
        <LinkButton
          :isFull="false"
          :href="route('products.create')"
          class="bg-red-500 text-sm"
        >
          商品投稿
        </LinkButton>
      </div>
      <div class="flex items-center justify-between">
        <p>Atopic laboにようこそ！</p>
        <div v-if="$page.props.auth.user">
          <Link
            :href="route('mypage')"
            class="mr-5 text-indigo-600 hover:text-indigo-400"
          >
            マイページ
          </Link>
          <button
            :disabled="form.processing"
            class="text-indigo-600 hover:text-indigo-400"
            @click="onButtonClicked"
          >
            ログアウト
          </button>
        </div>
        <div class="text-right" v-else>
          <Link
            :href="route('login')"
            class="mr-5 text-indigo-600 hover:text-indigo-400"
          >
            ログイン
          </Link>
          <Link
            :href="route('register')"
            class="text-indigo-600 hover:text-indigo-400"
          >
            会員登録
          </Link>
        </div>
      </div>
    </div>
  </header>
</template>
