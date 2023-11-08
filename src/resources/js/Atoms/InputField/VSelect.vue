<script setup>
import { useField, Field } from "vee-validate";
import { watch } from "vue";

const props = defineProps({
  validationName: {
    type: String,
    required: true,
  },
  items: Array,
  value: [Number, String],
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
  <Field
    v-model="fieldValue"
    :name="validationName"
    as="select"
    class="w-full rounded border-gray-300"
  >
    <option value="" hidden>選択してください</option>
    <option
      v-for="item in items"
      :key="item.id"
      :value="item.id"
    >
      {{ item.label }}
    </option>
  </Field>
</template>
