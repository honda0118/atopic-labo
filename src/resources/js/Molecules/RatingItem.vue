<script setup>
import VLabel from "@/Atoms/Label/VLabel.vue";
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import StarRating from "vue-star-rating";
import { useField } from "vee-validate";

const props = defineProps({
  validationName: {
    type: String,
    required: true,
  },
  label: String,
  value: Number,
});

const { value: fieldValue, errorMessage } = useField(() => props.validationName, undefined, {
  initialValue: props.value,
});
</script>

<template>
  <div>
    <VLabel class="mb-1">{{ label }}</VLabel>
    <StarRating
      v-model:rating="fieldValue"
      :increment="1"
      :star-size="40"
      :show-rating="false"
      :read-only="false"
      active-color="orange"
    />
    <ErrorText class="mt-2" :text="errorMessage" />
  </div>
</template>
