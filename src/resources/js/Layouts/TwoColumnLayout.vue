<script setup>
import TwoColumnLayoutHeader from "@/Organisms/TwoColumnLayoutHeader.vue";
import VFooter from "@/Organisms/VFooter.vue";
</script>

<template>
  <TwoColumnLayoutHeader />
  <slot />
  <VFooter />
</template>
