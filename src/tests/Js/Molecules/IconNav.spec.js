import IconNav from "@/Molecules/IconNav.vue";
import { Link } from "@inertiajs/vue3";
import { mount } from "@vue/test-utils";

describe("IconNavコンポーネントテスト", () => {
  test("slot", () => {
    const options = {
      slots: {
        default: "test_default",
      },
      props: {
        href: "/test_ref",
      },
    };
    const wrapper = mount(IconNav, options);
    const actualText = wrapper.text();

    // 「test_default」を表示すること
    expect(actualText).toContain("test_default");
  });
  test("props href", () => {
    const options = {
      props: {
        href: "/test_ref",
      },
    };
    const wrapper = mount(IconNav, options);
    const actualHref = wrapper.getComponent(Link).props().href;

    // Linkコンポーネントはprops href「/test_ref」を持つこと
    expect(actualHref).toBe("/test_ref");
  });
  test("props nav", () => {
    const options = {
      props: {
        nav: "test_nav",
        href: "/test_ref",
      },
    };
    const wrapper = mount(IconNav, options);
    const actualText = wrapper.text();

    // 「test_nav」を表示すること
    expect(actualText).toContain("test_nav");
  });
});
