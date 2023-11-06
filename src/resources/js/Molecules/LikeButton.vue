<script setup>
import LikeIcon from "@/Atoms/Icon/LikeIcon.vue";

defineProps({
  isDisabled: {
    type: Boolean,
    default: false,
  },
  isFull: Boolean,
  number: Number,
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
    <LikeIcon :isFull="isFull" class="mr-2" />
    {{ number }}
  </button>
</template>
