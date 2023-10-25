import ErrorText from "@/Atoms/Text/ErrorText.vue";
import { mount } from "@vue/test-utils";

describe("ErrorTextコンポーネントテスト", () => {
  test("props text", () => {
    const options = {
      props: {
        text: "test_text",
      },
    };
    const wrapper = mount(ErrorText, options);
    const actualText = wrapper.text();

    // 「test_text」を表示すること
    expect(actualText).toContain(options.props.text);
  });
});
