import BackIcon from "@/Atoms/Icon/BackIcon.vue";
import { mount } from "@vue/test-utils";

describe("BackIconコンポーネントテスト", () => {
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const wrapper = mount(BackIcon);
    await wrapper.get("svg").trigger("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
});
