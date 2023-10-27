<script setup>
const emit = defineEmits(["click"]);

const onButtonClicked = () => {
  emit("click");
};
</script>

<template>
  <button
    class="w-full rounded py-2 text-center text-lg font-black text-red-500 hover:bg-red-100"
    type="button"
    @click="onButtonClicked"
  >
    キャンセル
  </button>
</template>
