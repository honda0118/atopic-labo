import LinkButton from "@/Atoms/Button/LinkButton.vue";
import { Link } from "@inertiajs/vue3";
import { mount } from "@vue/test-utils";

describe("LinkButtonコンポーネントテスト", () => {
  test("slot", () => {
    const options = {
      slots: {
        default: "test_default",
      },
      props: {
        href: "/test_href",
      },
    };
    const wrapper = mount(LinkButton, options);
    const actualText = wrapper.text();

    // 「test_default」を表示すること
    expect(actualText).toContain(options.slots.default);
  });
  test("props isFull default false", () => {
    const options = {
      props: {
        href: "/test_href",
      },
    };
    const wrapper = mount(LinkButton, options);
    const linkComponent = wrapper.getComponent(Link);
    const actualClasses = linkComponent.classes();

    // Linkコンポーネントはclass属性値「w-full」を持たないこと
    expect(actualClasses).not.toContain("w-full");
  });
  test("props isFull true", () => {
    const options = {
      props: {
        isFull: true,
        href: "/test_href",
      },
    };
    const wrapper = mount(LinkButton, options);
    const linkComponent = wrapper.getComponent(Link);
    const actualClasses = linkComponent.classes();

    // Linkコンポーネントはclass属性値「w-full」を持つこと
    expect(actualClasses).toContain("w-full");
  });
  test("props href", () => {
    const options = {
      props: {
        href: "/test_href",
      },
    };
    const wrapper = mount(LinkButton, options);
    const linkComponent = wrapper.getComponent(Link);
    const actualHref = linkComponent.attributes().href;

    // Linkコンポーネントはhref属性値「/test_href」を持つこと
    expect(actualHref).toBe(options.props.href);
  });
});
