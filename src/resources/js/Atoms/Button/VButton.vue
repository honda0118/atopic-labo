<script setup>
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

const onButtonClicked = () => {
  emit("click");
};
</script>

<template>
  <button
    :class="{ 'opacity-25': isDisabled, 'w-full': isFull }"
    :disabled="isDisabled"
    :type="type"
    class="rounded px-3 py-2 text-lg font-bold text-white hover:brightness-90"
    @click="onButtonClicked"
  >
    <slot />
  </button>
</template>
