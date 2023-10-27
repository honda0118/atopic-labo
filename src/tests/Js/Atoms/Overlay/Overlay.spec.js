import Overlay from "@/Atoms/Overlay/Overlay.vue";
import { mount } from "@vue/test-utils";

describe("Overlayコンポーネントテスト", () => {
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const wrapper = mount(Overlay);
    await wrapper.get("div").trigger("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
});
