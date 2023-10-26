import InputText from "@/Atoms/InputField/InputText.vue";
import InputTextItem from "@/Molecules/InputTextItem.vue";
import { mount } from "@vue/test-utils";

describe("InputTextItemコンポーネントテスト", () => {
  test("props validationName", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputTextItem, options);
    const InputTextComponent = wrapper.getComponent(InputText);

    // InputTextコンポーネントはprops validationName「test_validationName」を持つこと
    expect(InputTextComponent.props().validationName).toBe(options.props.validationName);
  });
  test("props isRightAligned default false", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputTextItem, options);
    const InputTextComponent = wrapper.getComponent(InputText);

    // InputTextコンポーネントはprops isRightAligned「false」を持つこと
    expect(InputTextComponent.props().isRightAligned).toBeFalsy();
  });
  test("props type default text", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputTextItem, options);
    const InputTextComponent = wrapper.getComponent(InputText);

    // InputTextコンポーネントはprops type「text」を持つこと
    expect(InputTextComponent.props().type).toBe("text");
  });
  test("props id", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        id: "test_id",
      },
    };
    const wrapper = mount(InputTextItem, options);
    const InputTextComponent = wrapper.getComponent(InputText);

    // InputTextコンポーネントはprops id「test_id」を持つこと
    expect(InputTextComponent.props().id).toBe("test_id");
  });
  test("props label", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        label: "test_label",
      },
    };
    const wrapper = mount(InputTextItem, options);
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
    const wrapper = mount(InputTextItem, options);
    const InputTextComponent = wrapper.getComponent(InputText);

    // InputTextコンポーネントはprops placeholder「test_placeholder」を持つこと
    expect(InputTextComponent.props().placeholder).toBe("test_placeholder");
  });
  test("props value", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        value: "test_value",
      },
    };
    const wrapper = mount(InputTextItem, options);
    const InputTextComponent = wrapper.getComponent(InputText);

    // InputTextコンポーネントはprops value「test_value」を持つこと
    expect(InputTextComponent.props().value).toBe("test_value");
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
    const wrapper = mount(InputTextItem, options);
    const inputTextComponent = wrapper.getComponent(InputText);
    const expected = "test error";
    await inputTextComponent.vm.$emit("error", expected);
    const actualText = wrapper.text();

    // エラーイベントが発火すると、エラーメッセージ「test error」を表示すること
    expect(actualText).toContain(expected);
  });
});
