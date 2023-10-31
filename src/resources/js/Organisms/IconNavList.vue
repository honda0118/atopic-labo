<script setup>
import IconNav from "@/Molecules/IconNav.vue";
import RankingIcon from "@/Atoms/Icon/RankingIcon.vue";
import BrandIcon from "@/Atoms/Icon/BrandIcon.vue";
import CategoryIcon from "@/Atoms/Icon/CategoryIcon.vue";
</script>

<template>
  <nav class="flex">
    <IconNav class="mr-4 w-1/3" href="" nav="ランキング">
      <RankingIcon class="mx-auto" />
    </IconNav>
    <IconNav class="mr-4 w-1/3" href="" nav="カテゴリー">
      <BrandIcon class="mx-auto" />
    </IconNav>
    <IconNav href="" class="w-1/3" nav="ブランド">
      <CategoryIcon class="mx-auto" />
    </IconNav>
  </nav>
</template>
