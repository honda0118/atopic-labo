<script setup>
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import Mypage from "@/Organisms/Mypage.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
  <OneColumnLayout heading="マイページ">
    <Head title="マイページ" />
    <Mypage />
  </OneColumnLayout>
</template>
