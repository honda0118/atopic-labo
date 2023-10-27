<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import UserPasswordEditForm from "@/Organisms/UserPasswordEditForm.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <OneColumnLayout heading="パスワード編集">
    <Head title="パスワード編集" />
    <UserPasswordEditForm />
  </OneColumnLayout>
</template>
