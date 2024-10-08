import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { createPinia } from "pinia";

// vee-validate
import { defineRule, configure } from "vee-validate";
import { localize } from "@vee-validate/i18n";
import ja from "@vee-validate/i18n/dist/locale/ja.json";
import * as allRules from "@vee-validate/rules";

Object.keys(allRules).forEach((rule) => {
  defineRule(rule, allRules[rule]);
});

defineRule('custom_url', value => {
  const regexp = new RegExp(/^(https|http):\/\/.*/);

  if (!regexp.test(value)) {
    return "購入サイトは有効なURLではありません";
  }

  return true;
});

defineRule('price_including_tax', value => {
  const regexp = new RegExp(/^[1-9][0-9]*$/);

  if (!regexp.test(value)) {
    return "税込価格は正の整数を指定してください";
  }

  return true;
});

configure({
  generateMessage: localize("ja", {
    messages: ja.messages,
    names: {
      name: "名前",
      email: "メールアドレス",
      password: "パスワード",
      passwordConfirm: "パスワード再入力",
      icon: "アイコン",
      brandId: "ブランド",
      categoryId: "カテゴリー",
      productName: "商品名",
      productDescription: "商品説明",
      priceIncludingTax: "税込価格",
      purchaseSite: "購入サイト",
      productImage1: "商品画像",
      productImage2: "商品画像",
      productImage3: "商品画像",
      review: "クチコミ",
      reviewText: "本文",
      score: "満足度",
    },
    fields: {
      icon: {
        size: "8MB以下の画像を選択してください",
      },
      passwordConfirm: {
        confirmed: "入力したパスワードと一致しません",
      },
      email: {
        email: "有効なメールアドレスではありません",
      },
      productImage1: {
        required: "商品画像を選択してください",
        size: "8MB以下の画像を選択してください",
      },
      productImage2: {
        required: "商品画像を選択してください",
        size: "8MB以下の画像を選択してください",
      },
      productImage3: {
        required: "商品画像を選択してください",
        size: "8MB以下の画像を選択してください",
      },
      priceIncludingTax: {
        max_value: "税込価格は10万円以下で指定してください",
      },
    },
  }),
});

const appName = window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue")),
  setup({ el, App, props, plugin }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(createPinia())
      .mount(el);
  },
  progress: {
    color: "#4B5563",
  },
});
