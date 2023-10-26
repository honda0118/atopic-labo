import ListItemChevronRightIcon from "@/Molecules/ListItemChevronRightIcon.vue";
import { mount } from "@vue/test-utils";

describe("ListItemChevronRightIconコンポーネントテスト", () => {
  test("props isSmall default false", () => {
    const wrapper = mount(ListItemChevronRightIcon);
    const actualClasses = wrapper.get("li").classes();

    // li要素はclass属性値「py-4」を持つこと
    expect(actualClasses).toContain("py-4");
  });
  test("props isSmall true", () => {
    const options = {
      props: {
        isSmall: true,
      },
    };
    const wrapper = mount(ListItemChevronRightIcon, options);
    const actualClasses = wrapper.get("li").classes();

    // li要素はclass属性値「text-sm py-2」を持つこと
    expect(actualClasses).toContain("text-sm");
    expect(actualClasses).toContain("py-2");
  });
  test("props nav", () => {
    const options = {
      props: {
        nav: "test_nav",
      },
    };
    const wrapper = mount(ListItemChevronRightIcon, options);
    const actualText = wrapper.get("li").text();

    // 「test_nav」を表示すること
    expect(actualText).toContain(options.props.nav);
  });
});
