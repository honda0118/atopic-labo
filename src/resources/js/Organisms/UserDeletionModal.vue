<script setup>
import Overlay from "@/Atoms/Overlay/Overlay.vue";
import CancelMenu from "@/Molecules/CancelMenu.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
  isOpen: Boolean,
});

const emit = defineEmits(["close"]);

const close = () => {
  emit("close");
};

const form = useForm({});

const onButtonClicked = () => {
  form.delete(route("profile.destroy"));
};
</script>

<template>
  <teleport to="body">
    <div
      v-if="isOpen"
      class="fixed left-0 top-0 z-50 h-full w-full"
    >
      <Overlay @click="close" />
      <div class="absolute left-1/2 top-1/2 w-72 transform">
        <CancelMenu
          :isDisabled="form.processing"
          buttonName="退会する"
          title="退会しますか？"
          @="{ cancel: close, click: onButtonClicked }"
        />
      </div>
    </div>
  </teleport>
</template>

<style scoped>
.transform {
  transform: translateX(-50%) translateY(-50%);
}
</style>
