<script setup>
import ErrorText from "@/Atoms/Text/ErrorText.vue";
import VButton from "@/Atoms/Button/VButton.vue";
import SelectItem from "@/Molecules/SelectItem.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import InputTextAreaItem from "@/Molecules/InputTextAreaItem.vue";
import InputFileItemImage from "@/Molecules/InputFileItemImage.vue";
import { useFlashMessageStore } from "@/stores/flashMessage";
import { useForm } from "@inertiajs/vue3";
import { useForm as useFormValidate } from "vee-validate";
import { computed } from "vue";

const props = defineProps({
  brands: Array,
  categories: Array,
  product: Object,
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
    productImage1: "size:8192|mimes:image/jpeg,image/png",
    productImage2: "size:8192|mimes:image/jpeg,image/png",
    productImage3: "size:8192|mimes:image/jpeg,image/png",
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
  form.post(route("products.update", { product: props.product.id }), {
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

// image
const fileSystemUrl = import.meta.env.VITE_FILESYSTEM_URL;

const image = computed(() => (index) => {
  if (props.product.product_images[index]) {
    return fileSystemUrl + "/images/product/" + props.product.product_images[index].image;
  }
  return fileSystemUrl + "/images/product/product_sample.jpg";
});
</script>

<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="mb-4">
      <SelectItem
        :items="formatedBrands"
        :value="product.brand_id"
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
        :value="product.category_id"
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
        :value="product.name"
        label="商品名"
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
        :value="product.description"
        label="商品説明"
        validationName="productDescription"
      />
      <ErrorText
        :text="form.errors.description"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputTextItem
        id="price-including-tax"
        :isRightAligned="true"
        :value="product.price_including_tax"
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
        :value="product.purchase_site"
        label="購入サイト"
        validationName="purchaseSite"
      />
      <ErrorText
        :text="form.errors.purchase_site"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputFileItemImage
        :src="image(0)"
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像1枚目"
        validationName="productImage1"
      />
      <ErrorText
        :text="form.errors.image1"
        class="mt-2"
      />
    </div>
    <div class="mb-4">
      <InputFileItemImage
        :src="image(1)"
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像2枚目"
        validationName="productImage2"
      />
      <ErrorText
        :text="form.errors.image2"
        class="mt-2"
      />
    </div>
    <div class="mb-8">
      <InputFileItemImage
        :src="image(2)"
        accept="image/jpeg, image/png"
        alt="商品画像"
        label="商品画像3枚目"
        validationName="productImage3"
      />
      <ErrorText
        :text="form.errors.image3"
        class="mt-2"
      />
    </div>
    <VButton  
      :isDisabled="form.processing"
      :isFull="true"
      class="bg-red-500"
    >
      更新する
    </VButton>
  </form>
</template>
