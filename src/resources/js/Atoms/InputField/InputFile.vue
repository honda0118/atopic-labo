<script setup>
import { useField, Field } from "vee-validate";
import { watch } from "vue";

const props = defineProps({
  validationName: {
    type: String,
    required: true,
  },
  accept: String,
});

const emit = defineEmits(["error", "change", "cancel"]);

const { errorMessage } = useField(() => props.validationName);

watch(errorMessage, () => {
  emit("error", errorMessage.value);
});

const onFileChanged = (e) => {
  // 最大ファイルサイズは4MB
  const MAX_FILE_SIZE_BYTES = 4194304;

  const isValidationError = () => {
    if (
      !e.target.files.length ||
      e.target.files[0].size > MAX_FILE_SIZE_BYTES ||
      (e.target.files[0].type !== "image/jpeg" && e.target.files[0].type !== "image/png")
    ) {
      return true;
    }
  };

  // バリデーションエラーならファイルキャンセルイベントを発火させる。
  // 発火しないと、親コンポーネントでバリデーションエラーになった画像を表示してしまうため。
  if (isValidationError()) {
    return emit("cancel");
  }

  const reader = new FileReader();
  reader.onload = (e) => {
    // resultにはbase64エンコーディングされたファイルデータが格納されている
    emit("change", e.target.result);
  };
  // ファイルを読み込んでonloadイベントを発火させる
  reader.readAsDataURL(e.target.files[0]);
};
</script>

<template>
  <label class="cursor-pointer rounded border border-red-500 p-2 text-sm font-medium text-red-500 hover:bg-red-100">
    <Field
      :accept="accept"
      :name="validationName"
      class="hidden"
      type="file"
      @change="onFileChanged"
    />
    画像を選択する
  </label>
</template>
