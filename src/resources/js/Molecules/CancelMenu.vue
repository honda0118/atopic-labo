<script setup>
import VButton from "@/Atoms/Button/VButton.vue";
import CancelButton from "@/Atoms/Button/CancelButton.vue";

defineProps({
  buttonName: String,
  isDisabled: Boolean,
  title: String,
});

const emit = defineEmits(["click", "cancel"]);

const onButtonClicked = () => {
  emit("click");
};

const cancel = () => {
  emit("cancel");
};
</script>

<template>
  <div class="rounded bg-white p-4">
    <p class="mb-6 text-center text-xl font-black text-gray-700">{{ title }}</p>
    <VButton
      :isDisabled="isDisabled"
      :isFull="true"
      class="mb-4 bg-red-500"
      type="button"
      @click="onButtonClicked"
    >
      {{ buttonName }}
    </VButton>
    <CancelButton @click="cancel">キャンセル</CancelButton>
  </div>
</template>
