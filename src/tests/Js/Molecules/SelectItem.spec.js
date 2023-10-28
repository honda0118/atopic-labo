import VSelect from "@/Atoms/InputField/VSelect.vue";
import SelectItem from "@/Molecules/SelectItem.vue";
import { mount } from "@vue/test-utils";

describe("SelectItemコンポーネントテスト", () => {
  test("props items", () => {
    const options = {
      props: {
        items: [{ id: 1 }],
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(SelectItem, options);
    const actualItems = wrapper.getComponent(VSelect).props().items;

    // VSelectコンポーネントはprops items「{ id: 1 }」を持つこと
    expect(actualItems).toContain(options.props.items[0]);
  });
  test("props label", () => {
    const options = {
      props: {
        label: "test_label",
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(SelectItem, options);
    const actualText = wrapper.text();

    // 「test_label」を表示すること
    expect(actualText).toContain(options.props.label);
  });
  test("props validationName", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(SelectItem, options);
    const actualValidationName = wrapper.getComponent(VSelect).props().validationName;

    // VSelectコンポーネントはprops validationName「test_validationName」を持つこと
    expect(actualValidationName).toBe(options.props.validationName);
  });
  test("props value", () => {
    const options = {
      props: {
        value: "test_value",
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(SelectItem, options);
    const actualValue = wrapper.getComponent(VSelect).props().value;

    // VSelectコンポーネントはprops value「test_value」を持つこと
    expect(actualValue).toBe(options.props.value);
  });
  test("event error", async () => {
    const options = {
      global: {
        stubs: {
          VSelect: true,
        },
      },
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(SelectItem, options);
    const vSelectComponent = wrapper.getComponent(VSelect);
    const expected = "test error";
    await vSelectComponent.vm.$emit("error", expected);
    const actualText = wrapper.text();

    // エラーイベントが発火すると、エラーメッセージ「test error」を表示すること
    expect(actualText).toContain(expected);
  });
});
