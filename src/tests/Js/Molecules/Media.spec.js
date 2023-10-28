import Media from "@/Molecules/Media.vue";
import { mount } from "@vue/test-utils";

describe("Mediaコンポーネントテスト", () => {
  test("props alt", () => {
    const options = {
      props: {
        alt: "test_alt",
      },
    };
    const wrapper = mount(Media, options);
    const actualAlt = wrapper.get("img").attributes().alt;

    // Mediaコンポーネントはalt属性値「test_alt」を持つこと
    expect(actualAlt).toContain(options.props.alt);
  });
  test("props src", () => {
    const options = {
      props: {
        src: "/test_src/test.png",
      },
    };
    const wrapper = mount(Media, options);
    const actualSrc = wrapper.get("img").attributes().src;

    // Mediaコンポーネントはsrc属性値「/test_src/test.png」を持つこと
    expect(actualSrc).toContain(options.props.src);
  });
});
