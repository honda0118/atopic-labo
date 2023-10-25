<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import UserRegisterForm from "@/Organisms/UserRegisterForm.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <OneColumnLayout heading="会員登録">
    <Head title="会員登録" />
    <UserRegisterForm />
  </OneColumnLayout>
</template>