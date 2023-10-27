import { ref, watch, onUnmounted } from "vue";

export function useModal() {
  const isOpen = ref(false);

  watch(isOpen, () => {
    if (isOpen.value) {
      document.addEventListener("touchmove", disableScroll, {
        passive: false,
      });
      document.addEventListener("mousewheel", disableScroll, {
        passive: false,
      });
    } else {
      removeEventListener();
    }
  });

  onUnmounted(() => {
    removeEventListener();
  });

  const disableScroll = (event) => {
    event.preventDefault();
  };

  const removeEventListener = () => {
    document.removeEventListener("touchmove", disableScroll, {
      passive: false,
    });
    document.removeEventListener("mousewheel", disableScroll, {
      passive: false,
    });
  };
  return { isOpen };
}
