<script setup>
import { useField, Field } from "vee-validate";
import { watch } from "vue";

const props = defineProps({
  validationName: {
    type: String,
    required: true,
  },
  id: String,
  placeholder: String,
  value: String,
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
  <textarea
    :id="id"
    v-model="fieldValue"
    :placeholder="placeholder"
    class="h-52 w-full rounded border-gray-300"
  ></textarea>
</template>
