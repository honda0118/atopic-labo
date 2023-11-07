<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import { useForm } from "@inertiajs/vue3";
import { useForm as useFormValidate } from "vee-validate";
import { useFlashMessageStore } from "@/stores/flashMessage";

// validation rules
const { handleSubmit } = useFormValidate({
  validationSchema: {
    password: "required|min:8",
    passwordConfirm: "required|confirmed:@password",
  },
});

// form
const form = useForm({
  password: "",
  password_confirmation: "",
});

const onSubmit = handleSubmit((values) => {
  form.password = values.password;
  form.password_confirmation = values.passwordConfirm;
  form.patch(route("profile.password.update"), {
    onSuccess: () => {
      useFlashMessageStore().setIsShow(true);
    },
  });
});
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <InputTextItem
        id="password"
        label="パスワード"
        placeholder="8文字以上の半角英数字"
        type="password"
        validationName="password"
      />
      <ErrorText :text="form.errors.password" class="mt-2" />
    </div>
    <div class="mb-8">
      <InputTextItem
        id="password-confirm"
        label="パスワードを再入力"
        type="password"
        validationName="passwordConfirm"
      />
    </div>
    <VButton :isDisabled="form.processing" :isFull="true" class="bg-red-500"> 更新する </VButton>
  </form>
</template>
