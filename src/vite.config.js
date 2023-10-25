import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { fileURLToPath, URL } from "url";

export default defineConfig({
  plugins: [
    laravel({
      input: "resources/js/app.js",
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  // viteホットリロード対応
  server: {
    host: true,
    hmr: {
      host: "localhost",
    },
  },
  test: {
    // テストAPIをimport不要でグローバルに利用する
    globals: true,
    // テストの実行環境を指定する。
    // JSDOMはJavaScriptで実装されたHTML/DOM互換APIで、ブラウザ環境をNode.js内でエミュレートできる。
    environment: "jsdom",
  },
  resolve: {
    alias: {
      "@": fileURLToPath(new URL("./resources/js", import.meta.url)),
    },
  },
});
