import IconNav from "@/Molecules/IconNav.vue";
import { mount } from "@vue/test-utils";

describe("IconNavコンポーネントテスト", () => {
  test("slot", () => {
    const options = {
      slots: {
        default: "test_default",
      },
    };
    const wrapper = mount(IconNav, options);
    const actualText = wrapper.text();

    // 「test_default」を表示すること
    expect(actualText).toContain("test_default");
  });
  test("props nav", () => {
    const options = {
      props: {
        nav: "test_nav",
      },
    };
    const wrapper = mount(IconNav, options);
    const actualText = wrapper.text();

    // 「test_nav」を表示すること
    expect(actualText).toContain("test_nav");
  });
});
