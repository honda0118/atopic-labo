<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import InputTextAreaItem from "@/Molecules/InputTextAreaItem.vue";
import RatingItem from "@/Molecules/RatingItem.vue";
import { useFlashMessageStore } from "@/stores/flashMessage";
import { useForm } from "@inertiajs/vue3";
import { useForm as useFormValidate } from "vee-validate";

const props = defineProps({
  product: Object,
});

// validation rules
const { handleSubmit } = useFormValidate({
  validationSchema: {
    reviewText: "required|max:1000",
    score: "required",
  },
});

// form
const form = useForm({
  text: "",
  score: 0,
});

const onSubmit = handleSubmit((values) => {
  form.text = values.reviewText;
  form.score = values.score;

  form.patch(route("reviews.update", { review: props.product.pivot.id }), {
    onSuccess: () => {
      useFlashMessageStore().setIsShow(true);
    },
  });
});
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <span class="mb-1 block font-bold text-gray-700">商品名</span>
      <span>{{ product.name }}</span>
    </div>
    <div class="mb-4">
      <InputTextAreaItem
        id="review-text"
        label="本文"
        validationName="reviewText"
        placeholder="商品を購入した動機、使用した感想などをお書きください。
例)敏感肌でも使えるのでありがたいです。冬の乾燥にも程よい保湿力でベタつかず、使いやすいです。"
        :value="product.pivot.text"
      />
      <ErrorText class="mt-2" :text="form.errors.text" />
    </div>
    <div class="mb-8">
      <RatingItem label="満足度" validationName="score" :value="product.pivot.score" />
      <ErrorText class="mt-2" :text="form.errors.score" />
    </div>
    <VButton class="bg-red-500" :isDisabled="form.processing" :isFull="true">更新する</VButton>
  </form>
</template>
