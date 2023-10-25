import VButton from "@/Atoms/Button/VButton.vue";
import { mount } from "@vue/test-utils";

describe("VButtonコンポーネントテスト", () => {
  test("slot", () => {
    const options = {
      slots: {
        default: "test_default",
      },
    };
    const wrapper = mount(VButton, options);
    const actualText = wrapper.text();

    // 「test_default」を表示すること
    expect(actualText).toContain(options.slots.default);
  });
  test("props isDisabled default", () => {
    const wrapper = mount(VButton);
    const elButton = wrapper.get("button");

    // button要素はclass属性値「opacity-25」を持たないこと
    const actualClasses = elButton.classes();
    expect(actualClasses).not.toContain("opacity-25");
    // button要素はdisabled属性を持たないこと
    expect(elButton.attributes()).not.toHaveProperty("disabled");
  });
  test("props isDisabled true", () => {
    const options = {
      props: {
        isDisabled: true,
      },
    };
    const wrapper = mount(VButton, options);
    const elButton = wrapper.get("button");

    // button要素はclass属性値「opacity-25」を持つこと
    const actualClasses = elButton.classes();
    expect(actualClasses).toContain("opacity-25");
    // button要素はdisabled属性を持つこと
    expect(elButton.attributes()).toHaveProperty("disabled");
  });
  test("props isFull default false", () => {
    const wrapper = mount(VButton);
    const elButton = wrapper.get("button");
    const actualClasses = elButton.classes();

    // button要素はclass属性値「w-full」を持たないこと
    expect(actualClasses).not.toContain("w-full");
  });
  test("props isFull true", () => {
    const options = {
      props: {
        isFull: true,
      },
    };
    const wrapper = mount(VButton, options);
    const elButton = wrapper.get("button");

    // button要素はclass属性値「w-full」を持つこと
    const actualClasses = elButton.classes();
    expect(actualClasses).toContain("w-full");
  });
  test("props type", () => {
    const options = {
      props: {
        type: "submit",
      },
    };
    const wrapper = mount(VButton, options);
    const elButton = wrapper.get("button");
    const actualType = elButton.attributes().type;

    // button要素はtype属性値「submit」を持つこと
    expect(actualType).toBe(options.props.type);
  });
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const wrapper = mount(VButton);
    await wrapper.get("button").trigger("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
});
