<script setup>
import VLabel from "@/Atoms/Label/VLabel.vue";
import InputText from "@/Atoms/InputField/InputText.vue";
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import { ref } from "vue";

defineProps({
  validationName: {
    type: String,
    required: true,
  },
  isRightAligned: {
    type: Boolean,
    default: false,
  },
  type: {
    type: String,
    default: "text",
  },
  id: String,
  label: String,
  placeholder: String,
  value: [Number, String],
});

const error = ref("");

const onErrorOccurred = (errorMessage) => {
  error.value = errorMessage;
};
</script>

<template>
  <div>
    <VLabel :for="id" class="mb-1">{{ label }}</VLabel>
    <InputText
      :id="id"
      :isRightAligned="isRightAligned"
      :placeholder="placeholder"
      :type="type"
      :validationName="validationName"
      :value="value"
      @error="onErrorOccurred"
    />
    <ErrorText
      :text="error"
      class="mt-2"
    />
  </div>
</template>
