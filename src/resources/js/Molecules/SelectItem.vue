<script setup>
import VLabel from "@/Atoms/Label/VLabel.vue";
import VSelect from "@/Atoms/InputField/VSelect.vue";
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import { ref } from "vue";

defineProps({
  items: Array,
  label: String,
  validationName: String,
  value: [Number, String],
});

const error = ref("");

const onErrorOccurred = (errorMessage) => {
  error.value = errorMessage;
};
</script>

<template>
  <div>
    <VLabel class="mb-1">{{ label }}</VLabel>
    <VSelect
      @error="onErrorOccurred"
      :validationName="validationName"
      :items="items"
      :value="value"
    />
    <ErrorText class="mt-2" :text="error" />
  </div>
</template>
