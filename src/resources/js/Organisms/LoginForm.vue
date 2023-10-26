<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import { useForm as useFormValidate } from "vee-validate";
import { useForm } from "@inertiajs/vue3";

// validation rules
const { handleSubmit } = useFormValidate({
  validationSchema: {
    email: "required|email",
    password: "required",
  },
});

// form
const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const onSubmit = handleSubmit((values) => {
  form.email = values.email;
  form.password = values.password;
  form.post(route("login"));
});

// guest user
const formGuestUser = useForm({
});

const onButtonClicked = () => {
  formGuestUser.post(route("login.guest"));
};
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <InputTextItem id="email" label="メールアドレス" type="email" validationName="email" />
      <ErrorText class="mt-2" :text="form.errors.email" />
    </div>
    <div class="mb-8">
      <InputTextItem id="password" label="パスワード" type="password" validationName="password" />
      <ErrorText class="mt-2" :text="form.errors.password" />
    </div>
    <VButton class="mb-8 bg-indigo-500" :isDisabled="form.processing" :isFull="true">ログイン</VButton>
    <VButton
      :isDisabled="formGuestUser.processing"
      :isFull="true"
      class="mb-4 bg-red-500"
      type="button"
      @click="onButtonClicked"
    >
      かんたんログイン
    </VButton>
    <p>かんたんログインボタンを押下後に、ゲストユーザーでログインできます。</p>
  </form>
</template>
