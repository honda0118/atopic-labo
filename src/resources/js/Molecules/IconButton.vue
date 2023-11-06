<script setup>
defineProps({
  isDisabled: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["click"]);

const onButtonClicked = () => {
  emit("click");
};
</script>

<template>
  <button
    :disabled="isDisabled"
    class="rounded-xl border border-gray-400 px-2 py-2 text-sm hover:bg-gray-200"
    type="button"
    @click="onButtonClicked"
  >
    <slot name="icon" />
    <slot />
  </button>
</template>
