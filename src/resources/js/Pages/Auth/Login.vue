<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import LoginForm from "@/Organisms/LoginForm.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <OneColumnLayout heading="ログイン">
    <Head title="ログイン" />
    <LoginForm />
  </OneColumnLayout>
</template>
