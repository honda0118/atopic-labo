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
  email: "",
  password: "",
  remember: false,
});

const onButtonClicked = () => {
  formGuestUser.email = "test@test.com";
  formGuestUser.password = "1234567890";
  formGuestUser.post(route("login"));
};
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <InputTextItem
        id="email"
        label="メールアドレス"
        type="email"
        validationName="email"
      />
      <ErrorText
        :text="form.errors.email"
        class="mt-2"
      />
    </div>
    <div class="mb-8">
      <InputTextItem
        id="password"
        label="パスワード"
        type="password"
        validationName="password"
      />
      <ErrorText
        :text="form.errors.password"
        class="mt-2"
      />
    </div>
    <VButton
      :isDisabled="form.processing"
      :isFull="true"
      class="mb-8 bg-indigo-500"
    >
      ログイン
    </VButton>
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
