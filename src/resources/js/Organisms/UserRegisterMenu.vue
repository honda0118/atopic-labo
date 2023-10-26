<script setup>
import LinkButton from "@/Atoms/Button/LinkButton.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import { useForm, Link } from "@inertiajs/vue3";

// guest user
const form = useForm({});

const onButtonClicked = () => {
  form.post(route("login.guest"));
};
</script>

<template>
  <div>
    <LinkButton
      :isFull="true"
      :href="route('register')"
      class="mb-8 bg-indigo-500"
    >
      会員登録
    </LinkButton>
    <VButton
      :isDisabled="form.processing"
      :isFull="true"
      class="mb-4 bg-red-500"
      type="button"
      @click="onButtonClicked"
    >
      かんたんログイン
    </VButton>
    <p>かんたんログインボタンを押下後に、ゲストユーザーでログインできます。</p>
  </div>
</template>
