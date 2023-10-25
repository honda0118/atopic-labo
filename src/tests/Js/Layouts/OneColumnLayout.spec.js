import OneColumnLayoutHeader from "@/Organisms/OneColumnLayoutHeader.vue";
import OneColumnLayout from "@/Layouts/OneColumnLayout.vue";
import { mount } from "@vue/test-utils";

describe("OneColumnLayoutコンポーネントテスト", () => {
  test("slot", () => {
    const options = {
      global: {
        stubs: {
          OneColumnLayoutHeader: true,
        },
      },
      slots: {
        default: "test_default",
      },
    };
    const wrapper = mount(OneColumnLayout, options);
    const actual = wrapper.text();

    // 「test_default」を表示すること
    expect(actual).toContain(options.slots.default);
  });
  test("props heading", () => {
    const options = {
      global: {
        stubs: {
          OneColumnLayoutHeader: true,
        },
      },
      props: {
        heading: "test_heading",
      },
    };
    const wrapper = mount(OneColumnLayout, options);
    const actualText = wrapper.text();

    // 「test_heading」を表示すること
    expect(actualText).toContain(options.props.heading);
  });
});
