<script setup>
import SearchIcon from "@/Atoms/Icon/SearchIcon.vue";

defineProps({
  placeholder: String,
});

const emit = defineEmits(["update:keyword"]);

const onInputed = (e) => {
  emit("update:keyword", e.target.value);
};
</script>

<template>
  <div class="relative">
    <input
      :placeholder="placeholder"
      class="w-full rounded border-gray-700"
      @input="onInputed"
    />
    <button>
      <SearchIcon class="absolute right-2 top-1/2 transform cursor-pointer" />
    </button>
  </div>
</template>

<style scoped>
.transform {
  transform: translateY(-50%);
}
</style>
