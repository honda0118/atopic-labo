import { defineStore } from "pinia";

export const useFlashMessageStore = defineStore({
  id: "flashMessage",
  state: () => ({
    isShow: false,
  }),
  actions: {
    setIsShow(isShow) {
      this.isShow = isShow;
    },
  },
});
