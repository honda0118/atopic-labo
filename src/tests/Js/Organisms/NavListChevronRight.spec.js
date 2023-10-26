import ListItemChevronRightIcon from "@/Molecules/ListItemChevronRightIcon.vue";
import NavListChevronRight from "@/Organisms/NavListChevronRight.vue";
import { Link } from "@inertiajs/vue3";
import { mount } from "@vue/test-utils";

describe("NavListChevronRightコンポーネントテスト", () => {
  test("props items", () => {
    const options = {
      props: {
        items: [
          {
            nav: "test_nav",
            href: "/test_href",
          },
        ],
      },
    };
    const wrapper = mount(NavListChevronRight, options);

    // Linkコンポーネントはhref属性値「/test_href」を持つこと
    const actualHref = wrapper.getComponent(Link).attributes().href;
    expect(actualHref).toBe(options.props.items[0].href);

    //「test_nav」を表示すること
    const actualText = wrapper.text();
    expect(actualText).toContain(options.props.items[0].nav);
  });
  test("props isSmall default false", () => {
    const options = {
      props: {
        items: [
          {
            nav: "test_nav",
            href: "/test_href",
          },
        ],
      },
    };
    const wrapper = mount(NavListChevronRight, options);

    // ListItemChevronRightIconコンポーネントはprops isSmall「false」を持つこと
    const actualIsSmall = wrapper.getComponent(ListItemChevronRightIcon).props().isSmall;
    expect(actualIsSmall).toBeFalsy();
  });
});
