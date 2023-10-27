<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import ProfileEditForm from "@/Organisms/ProfileEditForm.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <OneColumnLayout heading="プロフィール編集">
    <Head title="プロフィール編集" />
    <ProfileEditForm />
  </OneColumnLayout>
</template>
