<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import SelectItem from "@/Molecules/SelectItem.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import InputTextAreaItem from "@/Molecules/InputTextAreaItem.vue";
import RatingItem from "@/Molecules/RatingItem.vue";
import InputFileItemImage from "@/Molecules/InputFileItemImage.vue";
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
    priceIncludingTax: "required|max_value:100000|price_including_tax",
    purchaseSite: "required|custom_url|max:1500",
    productImage1: "required|size:8192|mimes:image/jpeg,image/png",
    productImage2: "size:8192|mimes:image/jpeg,image/png",
    productImage3: "size:8192|mimes:image/jpeg,image/png",
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
  purchase_site: "",
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
  form.purchase_site = values.purchaseSite;
  form.image1 = values.productImage1;
  form.image2 = values.productImage2;
  form.image3 = values.productImage3;
  form.text = values.reviewText;
  form.score = values.score;
  form.post(route("products.store"), {
    onSuccess: () => {
      useFlashMessageStore().setIsShow(true);
    },
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
      <SelectItem
        :items="formatedBrands"
        label="ブランド"
        validationName="brandId"
      />
      <ErrorText
        :text="form.errors.brand_id"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <SelectItem
        :items="formatedCategories"
        label="カテゴリー"
        validationName="categoryId"
      />
      <ErrorText
        :text="form.errors.category_id"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputTextItem
        id="product-name"
        label="商品名"
        placeholder="例)ポアクリア オイル"
        validationName="productName"
      />
      <ErrorText
        :text="form.errors.name"
        class="mt-2"
      />
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
      <ErrorText
        :text="form.errors.description"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputTextItem
        :isRightAligned="true"
        id="price-including-tax"
        label="税込価格"
        validationName="priceIncludingTax"
        placeholder="0"
      />
      <ErrorText
        :text="form.errors.price_including_tax"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputTextItem
        id="purchase-site"
        label="購入サイト"
        placeholder="例)https://www.amazon.co.jp/TIAS-%E3%83%98%E3%83%91%E3%83%AA%E3%83%B3%E9%A1%9E%E4%BC%BC%E7%89%A9%E8%B3%AA-%E3%83%92%E3%83%AB%E3%83%89%E3%82%B1%E3%82%A2-%E3%83%A2%E3%82%A4%E3%82%B9%E3%83%81%E3%83%A3%E2%80%95-500mL/dp/B0B8GNGN65/ref=sr_1_4?crid=2OUXPNWZ92L65&keywords=tias+%E3%83%92%E3%83%AB%E3%83%89%E3%82%B1%E3%82%A2&qid=1699696973&s=beauty&sprefix=%2Cbeauty%2C155&sr=1-4"
        validationName="purchaseSite"
      />
      <ErrorText
        :text="form.errors.purchase_site"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputFileItemImage
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像1枚目"
        :src="fileSystemUrl + '/images/product/product_sample.jpg'"
        validationName="productImage1"
      />
      <ErrorText
        :text="form.errors.image1"
        class="mt-2" 
      />
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
      <ErrorText
        :text="form.errors.image2"
        class="mt-2"
      />
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
      <ErrorText
        :text="form.errors.image3"
        class="mt-2"
      />
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
      <ErrorText
        :text="form.errors.text"
        class="mt-2"
      />
    </div>
    <div class="mb-8">
      <RatingItem
        label="満足度"
        validationName="score"
      />
      <ErrorText
        :text="form.errors.score"
        class="mt-2"
      />
    </div>
    <VButton
      :isDisabled="form.processing"
      :isFull="true"
      class="bg-red-500"
    >
      投稿する
    </VButton>
  </form>
</template>
