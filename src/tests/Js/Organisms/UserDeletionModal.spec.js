import Overlay from "@/Atoms/Overlay/Overlay.vue";
import CancelMenu from "@/Molecules/CancelMenu.vue";
import UserDeletionModal from "@/Organisms/UserDeletionModal.vue";
import { mount } from "@vue/test-utils";

describe("UserDeletionModalコンポーネントテスト", () => {
  test("props isOpen false", () => {
    const options = {
      props: {
        isOpen: false,
      },
    };
    const wrapper = mount(UserDeletionModal, options);
    const actualExists = wrapper.findComponent(CancelMenu).exists();

    // CancelMenuコンポーネントを表示しないこと
    expect(actualExists).toBeFalsy();
  });
  test("props isOpen true", () => {
    const options = {
      props: {
        isOpen: true,
      },
    };
    const wrapper = mount(UserDeletionModal, options);
    const actualExists = wrapper.getComponent(CancelMenu).exists();

    // CancelMenuコンポーネントを表示すること
    expect(actualExists).toBeTruthy();
  });
  test("clickイベントを親コンポーネントに通知すること", async () => {
    const options = {
      global: {
        stubs: {
          VButton: true,
        },
      },
      props: {
        isOpen: true,
      },
    };
    const wrapper = mount(UserDeletionModal, options);
    await wrapper.getComponent(Overlay).vm.$emit("click");
    const closeEvent = wrapper.emitted("close");

    expect(closeEvent.length).toBe(1);
  });
  test("cancelイベントを親コンポーネントに通知すること", async () => {
    const options = {
      global: {
        stubs: {
          VButton: true,
        },
      },
      props: {
        isOpen: true,
      },
    };
    const wrapper = mount(UserDeletionModal, options);
    await wrapper.getComponent(CancelMenu).vm.$emit("cancel");
    const closeEvent = wrapper.emitted("close");

    expect(closeEvent.length).toBe(1);
  });
});
