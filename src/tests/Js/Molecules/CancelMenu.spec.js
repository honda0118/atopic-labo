import VButton from "@/Atoms/Button/VButton.vue";
import CancelButton from "@/Atoms/Button/CancelButton.vue";
import CancelMenu from "@/Molecules/CancelMenu.vue";
import { mount } from "@vue/test-utils";

describe("CancelMenuコンポーネントテスト", () => {
  test("props isDisabled", () => {
    const options = {
      props: {
        isDisabled: true,
      },
    };
    const wrapper = mount(CancelMenu, options);
    const actualIsDisabled = wrapper.getComponent(VButton).props().isDisabled;

    // VButtonコンポーネントはprops isDisabled「true」を持つこと
    expect(actualIsDisabled).toBeTruthy();
  });
  test("props buttonName", () => {
    const options = {
      props: {
        buttonName: "test_buttonName",
      },
    };
    const wrapper = mount(CancelMenu, options);
    const actualText = wrapper.text();

    // 「test_buttonName」を表示すること
    expect(actualText).toContain(options.props.buttonName);
  });
  test("props title", () => {
    const options = {
      props: {
        title: "test_title",
      },
    };
    const wrapper = mount(CancelMenu, options);
    const actualText = wrapper.text();

    // 「test_title」を表示すること
    expect(actualText).toContain(options.props.title);
  });
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const options = {
      global: {
        stubs: {
          VButton: true,
        },
      },
    };
    const wrapper = mount(CancelMenu, options);
    await wrapper.getComponent(VButton).vm.$emit("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
  test("cancelイベントを親コンポーネントに通知すること", async () => {
    const options = {
      global: {
        stubs: {
          VButton: true,
        },
      },
    };
    const wrapper = mount(CancelMenu, options);
    await wrapper.getComponent(CancelButton).vm.$emit("click");
    const cancelEvent = wrapper.emitted("cancel");

    expect(cancelEvent.length).toBe(1);
  });
});
