import VLabel from "@/Atoms/Label/VLabel.vue";
import { mount } from "@vue/test-utils";

describe("VLabelコンポーネントテスト", () => {
  test("slot", () => {
    const options = {
      slots: {
        default: "test_default",
      },
    };
    const wrapper = mount(VLabel, options);
    const actualText = wrapper.text();

    // 「test_default」を表示すること
    expect(actualText).toContain(options.slots.default);
  });
  test("props for", () => {
    const options = {
      props: {
        for: "test_for",
      },
    };
    const wrapper = mount(VLabel, options);
    const actualFor = wrapper.get("label").attributes().for;

    // label要素はfor属性値「test_for」を持つこと
    expect(actualFor).toBe(options.props.for);
  });
});
