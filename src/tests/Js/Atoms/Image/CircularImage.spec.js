import CircularImage from "@/Atoms/Image/CircularImage.vue";
import { mount } from "@vue/test-utils";

describe("CircularImageコンポーネントテスト", () => {
  test("props alt", () => {
    const options = {
      props: {
        alt: "test_alt",
      },
    };
    const wrapper = mount(CircularImage, options);
    const actualAlt = wrapper.get("img").attributes().alt;

    // img要素はalt属性値「test_alt」を持つこと
    expect(actualAlt).toBe(options.props.alt);
  });
  test("props src", () => {
    const options = {
      props: {
        src: "tet_src.jpg",
      },
    };
    const wrapper = mount(CircularImage, options);
    const actualSrc = wrapper.get("img").attributes().src;

    // img要素はsrc属性値「tet_src.jpg」を持つこと
    expect(actualSrc).toBe(options.props.src);
  });
  test("props isSmall default", () => {
    const wrapper = mount(CircularImage);
    const actualClasses = wrapper.get("img").classes();

    // img要素はclass属性値「h-24」を持つこと
    expect(actualClasses).toContain("h-24");
  });
  test("props isSmall true", () => {
    const options = {
      props: {
        isSmall: true,
      },
    };
    const wrapper = mount(CircularImage, options);
    const actualClasses = wrapper.get("img").classes();

    // img要素はclass属性値「h-24」を持たないこと
    expect(actualClasses).not.toContain("h-24");
  });
});
