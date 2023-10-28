<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import SelectItem from "@/Molecules/SelectItem.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import InputTextAreaItem from "@/Molecules/InputTextAreaItem.vue";
import RatingItem from "@/Molecules/RatingItem.vue";
import InputFileItemImage from "@/Molecules/InputFileItemImage.vue";
import { validatePriceIncludingTax, validateReleasedAt } from "@/Modules/validation";
import { useFlashMessageStore } from "@/stores/flashMessage";
import { useForm } from "@inertiajs/vue3";
import { useForm as useFormValidate } from "vee-validate";
import { computed } from "vue";

const props = defineProps({
  brands: Array,
  categories: Array,
});

// validation rules
const { handleSubmit } = useFormValidate({
  validationSchema: {
    brandId: "required",
    categoryId: "required",
    productName: "required|max:50",
    productDescription: "required|max:1000",
    priceIncludingTax: (value) => {
      const errorMessage = validatePriceIncludingTax(value);

      if (errorMessage) {
        return errorMessage;
      }
      return true;
    },
    releasedAt: (value) => {
      const errorMessage = validateReleasedAt(value);

      if (errorMessage) {
        return errorMessage;
      }
      return true;
    },
    productImage1: "required|size:4096|mimes:image/jpeg,image/png",
    productImage2: "size:4096|mimes:image/jpeg,image/png",
    productImage3: "size:4096|mimes:image/jpeg,image/png",
    reviewText: "required|max:1000",
    score: "required",
  },
});

// form
const form = useForm({
  brand_id: 0,
  category_id: 0,
  name: "",
  description: "",
  price_including_tax: 0,
  released_at: "",
  image1: null,
  image2: null,
  image3: null,
  text: "",
  score: 0,
});

const onSubmit = handleSubmit((values) => {
  form.brand_id = values.brandId;
  form.category_id = values.categoryId;
  form.name = values.productName;
  form.description = values.productDescription;
  form.price_including_tax = values.priceIncludingTax;
  form.released_at = values.releasedAt;
  form.image1 = values.productImage1;
  form.image2 = values.productImage2;
  form.image3 = values.productImage3;
  form.text = values.reviewText;
  form.score = values.score;
  form.post(route("products.store"), {
    onSuccess: () => {
      useFlashMessageStore().setIsShow(true);
    }
  });
});

// brands
const formatedBrands = computed(() => {
  return props.brands.map((brand) => ({
    id: brand.id,
    label: brand.name,
  }));
});

// categories
const formatedCategories = computed(() => {
  return props.categories.map((category) => ({
    id: category.id,
    label: category.name,
  }));
});

// file system url
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <SelectItem :items="formatedBrands" label="ブランド" validationName="brandId" />
      <ErrorText class="mt-2" :text="form.errors.brand_id" />
    </div>
    <div class="mb-4">
      <SelectItem :items="formatedCategories" label="カテゴリー" validationName="categoryId" />
      <ErrorText class="mt-2" :text="form.errors.category_id" />
    </div>
    <div class="mb-4">
      <InputTextItem
        id="product-name"
        label="商品名"
        placeholder="例)ポアクリア オイル"
        validationName="productName"
      />
      <ErrorText class="mt-2" :text="form.errors.name" />
    </div>
    <div class="mb-4">
      <InputTextAreaItem
        id="product-description"
        label="商品説明"
        validationName="productDescription"
        placeholder="例)毛穴に詰まった角栓もメイクもすっきりと落とす、高機能クレンジングオイルです。
毛穴の約20,000分の1サイズの微細な洗浄成分を配合しました。古い角質と皮脂が混ざり合った「固まり角栓」をやわらかくほぐし、スルンと除去。
毛穴の黒ずみやザラつきのない 、つるすべの肌に洗い上げます。心やすらぐグリーンフローラルの香り。"
      />
      <ErrorText class="mt-2" :text="form.errors.description" />
    </div>
    <div class="mb-4">
      <InputTextItem
        :isRightAligned="true"
        id="price-including-tax"
        label="税込価格"
        validationName="priceIncludingTax"
        placeholder="0"
      />
      <ErrorText class="mt-2" :text="form.errors.price_including_tax" />
    </div>
    <div class="mb-4">
      <InputTextItem id="released-at" label="発売日" validationName="releasedAt" type="date" />
      <ErrorText class="mt-2" :text="form.errors.released_at" />
    </div>
    <div class="mb-4">
      <InputFileItemImage
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像1枚目"
        :src="fileSystemUrl + '/images/product/product_sample.jpg'"
        validationName="productImage1"
      />
      <ErrorText class="mt-2" :text="form.errors.image1" />
    </div>
    <div class="mb-4">
      <InputFileItemImage
        :isShowOptionalIcon="true"
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像2枚目"
        :src="fileSystemUrl + '/images/product/product_sample.jpg'"
        validationName="productImage2"
      />
      <ErrorText class="mt-2" :text="form.errors.image2" />
    </div>
    <div class="mb-10">
      <InputFileItemImage
        :isShowOptionalIcon="true"
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像3枚目"
        :src="fileSystemUrl + '/images/product/product_sample.jpg'"
        validationName="productImage3"
      />
      <ErrorText class="mt-2" :text="form.errors.image3" />
    </div>
    <span class="mb-4 block bg-amber-100 p-2 text-center text-xl font-bold">クチコミ</span>
    <div class="mb-4">
      <InputTextAreaItem
        id="review-text"
        label="本文"
        validationName="reviewText"
        placeholder="商品を購入した動機、使用した感想などをお書きください。

例)敏感肌でも使えるのでありがたいです。冬の乾燥にも程よい保湿力でベタつかず、使いやすいです。"
      />
      <ErrorText class="mt-2" :text="form.errors.text" />
    </div>
    <div class="mb-8">
      <RatingItem label="満足度" validationName="score" />
      <ErrorText class="mt-2" :text="form.errors.score" />
    </div>
    <VButton class="bg-red-500" :isDisabled="form.processing" :isFull="true">投稿する</VButton>
  </form>
</template>
