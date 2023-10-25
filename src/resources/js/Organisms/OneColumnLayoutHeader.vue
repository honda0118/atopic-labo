<script setup>
import BackIcon from "@/Atoms/Icon/BackIcon.vue";
import Logo from "@/Atoms/Image/Logo.vue";
import { Link, useForm } from "@inertiajs/vue3";

const onIconClicked = () => {
  history.back();
};

// form
const form = useForm({});

const onButtonClicked = () => {
  form.post(route("logout"));
};
</script>

<template>
  <header class="border-b border-gray-300">
    <div class="relative mx-auto flex max-w-screen-sm items-center justify-center px-2 py-5">
      <BackIcon class="absolute left-5" @click="onIconClicked" />
      <Link href="/">
        <Logo />
      </Link>
      <button
        v-if="$page.props.auth.user"
        :disabled="form.processing"
        class="absolute right-5 text-indigo-600 hover:text-indigo-400"
        @click="onButtonClicked"
      >
        ログアウト
      </button>
    </div>
  </header>
</template>
