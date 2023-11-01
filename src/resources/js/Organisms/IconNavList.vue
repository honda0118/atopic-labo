<script setup>
import IconNav from "@/Molecules/IconNav.vue";
import RankingIcon from "@/Atoms/Icon/RankingIcon.vue";
import BrandIcon from "@/Atoms/Icon/BrandIcon.vue";
import CategoryIcon from "@/Atoms/Icon/CategoryIcon.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <nav class="flex">
    <Link href="" class="mr-4 w-1/3">
      <IconNav nav="ランキング">
        <RankingIcon />
      </IconNav>
    </Link>
    <Link :href="route('categories.index')" class="mr-4 w-1/3">
      <IconNav nav="カテゴリー">
        <BrandIcon />
      </IconNav>
    </Link>
    <Link :href="route('brands.index')" class="w-1/3">
      <IconNav nav="ブランド">
        <CategoryIcon />
      </IconNav>
    </Link>
  </nav>
</template>
