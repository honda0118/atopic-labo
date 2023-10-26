<script setup>
import UserRegisterMenu from "@/Organisms/UserRegisterMenu.vue";
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <OneColumnLayout heading="会員登録メニュー">
    <Head title="会員登録メニュー" />
    <UserRegisterMenu />
  </OneColumnLayout>
</template>
