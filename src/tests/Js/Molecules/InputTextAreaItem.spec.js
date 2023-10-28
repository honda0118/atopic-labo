import VTextArea from "@/Atoms/InputField/VTextArea.vue";
import InputTextAreaItem from "@/Molecules/InputTextAreaItem.vue";
import { mount } from "@vue/test-utils";

describe("InputTextAreaItemコンポーネントテスト", () => {
  test("props validationName", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputTextAreaItem, options);
    const actualValidationName = wrapper.getComponent(VTextArea).props().validationName;

    // InputTextコンポーネントはprops validationName「test_validationName」を持つこと
    expect(actualValidationName).toBe(options.props.validationName);
  });
  test("props id", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        id: "test_id",
      },
    };
    const wrapper = mount(InputTextAreaItem, options);
    const actualId = wrapper.getComponent(VTextArea).props().id;

    // InputTextコンポーネントはprops id「test_id」を持つこと
    expect(actualId).toBe("test_id");
  });
  test("props label", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        label: "test_label",
      },
    };
    const wrapper = mount(InputTextAreaItem, options);
    const actualText = wrapper.text();

    // 「test_label」を表示すること
    expect(actualText).toContain(options.props.label);
  });
  test("props placeholder", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        placeholder: "test_placeholder",
      },
    };
    const wrapper = mount(InputTextAreaItem, options);
    const actualPlaceholder = wrapper.getComponent(VTextArea).props().placeholder;

    // InputTextコンポーネントはprops placeholder「test_placeholder」を持つこと
    expect(actualPlaceholder).toBe("test_placeholder");
  });
  test("props value", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        value: "test_value",
      },
    };
    const wrapper = mount(InputTextAreaItem, options);
    const actualValue = wrapper.getComponent(VTextArea).props().value;

    // InputTextコンポーネントはprops value「test_value」を持つこと
    expect(actualValue).toBe("test_value");
  });
  test("error event", async () => {
    const options = {
      global: {
        stubs: {
          InputText: true,
        },
      },
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputTextAreaItem, options);
    const VTextAreaComponent = wrapper.getComponent(VTextArea);
    const expected = "test error";
    await VTextAreaComponent.vm.$emit("error", expected);
    const actualText = wrapper.text();

    // エラーイベントが発火すると、エラーメッセージ「test error」を表示すること
    expect(actualText).toContain(expected);
  });
});
