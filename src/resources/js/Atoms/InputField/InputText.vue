<script setup>
import { useField } from "vee-validate";
import { watch } from "vue";

const props = defineProps({
  validationName: {
    type: String,
    required: true,
  },
  isRightAligned: {
    type: Boolean,
    default: false,
  },
  placeholder: String,
  type: {
    type: String,
    default: "text",
  },
  id: String,
  value: [String, Number],
});

const emit = defineEmits(["error"]);

const { value: fieldValue, errorMessage } = useField(() => props.validationName, undefined, {
  initialValue: props.value,
});

watch(errorMessage, () => {
  emit("error", errorMessage.value);
});
</script>

<template>
  <input
    :id="id"
    v-model="fieldValue"
    :class="{ 'text-right': isRightAligned }"
    :placeholder="placeholder"
    :type="type"
    class="w-full rounded border-gray-300"
  />
</template>
