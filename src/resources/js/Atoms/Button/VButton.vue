<script setup>
import { ref } from "vue";

const props = defineProps({
  isDisabled: {
    type: Boolean,
    default: false,
  },
  isFull: {
    type: Boolean,
    default: false,
  },
  type: String,
});

const emit = defineEmits(["click"]);

const isDisabledExpose = ref(false);
defineExpose({
  isDisabledExpose
});

const onButtonClicked = () => {
  emit("click");
};
</script>

<template>
  <button
    :class="{ 'opacity-25': isDisabled | isDisabledExpose, 'w-full': isFull }"
    :disabled="isDisabled | isDisabledExpose"
    :type="type"
    class="rounded px-3 py-2 text-lg font-bold text-white hover:brightness-90"
    @click="onButtonClicked"
  >
    <slot />
  </button>
</template>
