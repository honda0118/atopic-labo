import LikeIcon from "@/Atoms/Icon/LikeIcon.vue";
import IconButton from "@/Molecules/IconButton.vue";
import { mount } from "@vue/test-utils";

describe("IconButtonコンポーネントテスト", () => {
  test("props isDisabled true", () => {
    const options = {
      props: {
        isDisabled: true,
      },
    };
    const wrapper = mount(IconButton, options);
    const actualAttributes = wrapper.get("button").attributes();

    // button要素はdisabled属性を持つこと
    expect(actualAttributes).toHaveProperty("disabled");
  });
  test("props isDisabled default false", () => {
    const wrapper = mount(IconButton);
    const actualAttributes = wrapper.get("button").attributes();

    // button要素はdisabled属性を持たないこと
    expect(actualAttributes).not.toHaveProperty("disabled");
  });
  test("slot default", () => {
    const options = {
      slots: {
        default: "test_default",
      },
    };
    const wrapper = mount(IconButton, options);
    const actualText = wrapper.text();

    // 「test_default」を表示すること
    expect(actualText).toContain(options.slots.default);
  });
  test("slot icon", () => {
    const options = {
      slots: {
        icon: LikeIcon,
      },
    };
    const wrapper = mount(IconButton, options);
    const actualExists = wrapper.getComponent(LikeIcon).exists();

    // LikeIconコンポーネントを表示すること
    expect(actualExists).toBeTruthy();
  });
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const wrapper = mount(IconButton);
    await wrapper.get("button").trigger("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
});
