<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import InputFileItemCircularImage from "@/Molecules/InputFileItemCircularImage.vue";
import { useForm } from "@inertiajs/vue3";
import { useForm as useFormValidate } from "vee-validate";
import { useFlashMessageStore } from "@/stores/flashMessage";

// validation rules
const { handleSubmit } = useFormValidate({
  validationSchema: {
    name: "required|max:50",
    email: "required|email|max:74",
    icon: "size:8192|mimes:image/jpeg,image/png",
  },
});

// form
const form = useForm({
  name: "",
  email: "",
  icon: null,
});

const onSubmit = handleSubmit((values) => {
  form.name = values.name;
  form.email = values.email;
  form.icon = values.icon;
  form.post(route("profile.update"), {
    onSuccess: () => {
      useFlashMessageStore().setIsShow(true);
    },
  });
});

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <InputTextItem
        id="name"
        :value="$page.props.auth.user.name"
        validationName="name"
        label="名前"
      />
      <ErrorText
        :text="form.errors.name"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputTextItem
        id="email"
        :value="$page.props.auth.user.email"
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
      <InputFileItemCircularImage
        :src="fileSystemUrl + '/images/icon/' + $page.props.auth.user.icon"
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
      更新する
    </VButton>
  </form>
</template>
