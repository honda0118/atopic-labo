import CancelButton from "@/Atoms/Button/CancelButton.vue";
import { mount } from "@vue/test-utils";

describe("CancelButtonコンポーネントテスト", () => {
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const wrapper = mount(CancelButton);
    await wrapper.get("button").trigger("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
});
