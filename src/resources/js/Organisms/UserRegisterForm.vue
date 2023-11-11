<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import InputFileItemCircularImage from "@/Molecules/InputFileItemCircularImage.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import { useForm } from "@inertiajs/vue3";
import { useForm as useFormValidate } from "vee-validate";

// validation rules
const { handleSubmit } = useFormValidate({
  validationSchema: {
    name: "required|max:50",
    email: "required|email|max:74",
    password: "required|min:8",
    passwordConfirm: "required|confirmed:@password",
    icon: "size:8192|mimes:image/jpeg,image/png",
  },
});

// form
const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  icon: null,
  terms: false,
});

const onSubmit = handleSubmit((values) => {
  form.name = values.name;
  form.email = values.email;
  form.password = values.password;
  form.password_confirmation = values.passwordConfirm;
  form.icon = values.icon;
  form.post(route("register"));
});

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <InputTextItem
        id="name"
        label="名前"
        validationName="name"
      />
      <ErrorText
        :text="form.errors.name"
        class="mt-2"
      />
    </div>
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
    <div class="mb-4">
      <InputTextItem
        id="password"
        label="パスワード"
        placeholder="8文字以上の半角英数字"
        type="password"
        validationName="password"
      />
      <ErrorText
        :text="form.errors.password"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputTextItem
        id="password-confirm"
        label="パスワードを再入力"
        type="password"
        validationName="passwordConfirm"
      />
    </div>
    <div class="mb-8">
      <InputFileItemCircularImage
        :isShowOptionalIcon="true"
        :src="fileSystemUrl + '/images/icon/default.png'"
        accept="image/jpeg, image/png"
        alt="アイコン"
        label="アイコン"
        validationName="icon"
      />
      <ErrorText
        :text="form.errors.icon"
        class="mt-2"
      />
    </div>
    <VButton
      :isDisabled="form.processing"
      :isFull="true"
      class="bg-red-500"
    >
      登録する
    </VButton>
  </form>
</template>
