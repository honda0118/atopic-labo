<script setup>
import VLabel from "@/Atoms/Label/VLabel.vue";
import VTextArea from "@/Atoms/InputField/VTextArea.vue";
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import { ref } from "vue";

defineProps({
  validationName: {
    type: String,
    required: true,
  },
  id: String,
  label: String,
  placeholder: String,
  value: String,
});

const error = ref("");

const onErrorOccurred = (errorMessage) => {
  error.value = errorMessage;
};
</script>

<template>
  <div>
    <VLabel :for="id" class="mb-1">{{ label }}</VLabel>
    <VTextArea
      :id="id"
      :placeholder="placeholder"
      :validationName="validationName"
      :value="value"
      @error="onErrorOccurred"
    />
    <ErrorText :text="error" />
  </div>
</template>
