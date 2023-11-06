import LikeIcon from "@/Atoms/Icon/LikeIcon.vue";
import LikeButton from "@/Molecules/LikeButton.vue";
import { mount } from "@vue/test-utils";

describe("LikeButtonコンポーネントテスト", () => {
  test("props isDisabled true", () => {
    const options = {
      props: {
        isDisabled: true,
      },
    };
    const wrapper = mount(LikeButton, options);
    const actualAttributes = wrapper.get("button").attributes();

    // button要素はdisabled属性を持つこと
    expect(actualAttributes).toHaveProperty("disabled");
  });
  test("props isDisabled default false", () => {
    const wrapper = mount(LikeButton);
    const actualAttributes = wrapper.get("button").attributes();

    // button要素はdisabled属性を持たないこと
    expect(actualAttributes).not.toHaveProperty("disabled");
  });
  test("props isFull", () => {
    const options = {
      props: {
        isFull: true,
      },
    };
    const wrapper = mount(LikeButton, options);
    const actualIsFull = wrapper.getComponent(LikeIcon).props().isFull;

    // LikeIconコンポーネントはprops isFull「true」を持つこと
    expect(actualIsFull).toBe(options.props.isFull);
  });
  test("props number", () => {
    const options = {
      props: {
        number: 100,
      },
    };
    const wrapper = mount(LikeButton, options);
    const actualText = wrapper.text();

    // 「100」を表示すること
    expect(actualText).toContain(options.props.number);
  });
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const wrapper = mount(LikeButton);
    await wrapper.get("button").trigger("click");
    const clickEvent = wrapper.emitted("click");

    expect(clickEvent.length).toBe(1);
  });
});
