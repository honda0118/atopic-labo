<script setup>
import VLabel from "@/Atoms/Label/VLabel.vue";
import OptionalIcon from "@/Atoms/Icon/OptionalIcon.vue";
import InputFile from "@/Atoms/InputField/InputFile.vue";
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import { ref, computed } from "vue";

const props = defineProps({
  validationName: {
    type: String,
    required: true,
  },
  isShowOptionalIcon: {
    type: Boolean,
    default: false,
  },
  accept: String,
  alt: String,
  label: String,
  src: String,
});

// error message
const error = ref("");

const onErrorOccurred = (errorMessage) => {
  error.value = errorMessage;
};

// image
const imageSrc = ref(props.src);
const src = computed(() => {
  return imageSrc.value;
});

const onFileChanged = (encodedFile) => {
  imageSrc.value = encodedFile;
};

const onFileCanceled = () => {
  imageSrc.value = props.src;
};
</script>

<template>
  <div>
    <div class="flex items-baseline">
      <VLabel class="mb-1 mr-1">{{ label }}</VLabel>
      <OptionalIcon v-if="isShowOptionalIcon" />
    </div>
    <div class="flex items-center">
      <img class="mr-8 h-28 w-28" :alt="alt" :src="src" />
      <InputFile :accept="accept" :validationName="validationName"
        @="{ error: onErrorOccurred, change: onFileChanged, cancel: onFileCanceled }" />
    </div>
    <ErrorText class="mt-2" :text="error" />
  </div>
</template>
