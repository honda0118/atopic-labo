import HeartIcon from "@/Atoms/Icon/HeartIcon.vue";
import { mount } from "@vue/test-utils";

describe("HeartIconコンポーネントテスト", () => {
  test("props isFull true", () => {
    const options = {
      props: {
        isFull: true,
      },
    };
    const wrapper = mount(HeartIcon, options);

    // svg要素はclass属性値「fill-pink-500」を持つこと
    const actualClasses = wrapper.get("svg").classes();
    expect(actualClasses).toContain("fill-pink-500");

    // svg要素はstroke-width属性値「0」を持つこと
    const actualStrokeWidth = wrapper.get("svg").attributes("stroke-width");
    expect(actualStrokeWidth).toBe("0");
  });
  test("props isFull false", () => {
    const options = {
      props: {
        isFull: false,
      },
    };
    const wrapper = mount(HeartIcon, options);

    // svg要素はclass属性値「fill-none」を持つこと
    const actualClasses = wrapper.get("svg").classes();
    expect(actualClasses).toContain("fill-none");

    // svg要素はstroke-width属性値「1」を持つこと
    const actualStrokeWidth = wrapper.get("svg").attributes("stroke-width");
    expect(actualStrokeWidth).toBe("1");
  });
});
