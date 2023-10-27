<script setup>
const emit = defineEmits(["click"]);

const onOverlayClicked = () => {
  emit("click");
};
</script>

<template>
  <div class="absolute h-full w-full bg-gray-500 opacity-75" @click="onOverlayClicked" />
</template>
