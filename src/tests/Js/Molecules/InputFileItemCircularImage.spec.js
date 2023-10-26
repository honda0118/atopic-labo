import InputFile from "@/Atoms/InputField/InputFile.vue";
import CircularImage from "@/Atoms/Image/CircularImage.vue";
import OptionalIcon from "@/Atoms/Icon/OptionalIcon.vue";
import InputFileItemCircularImage from "@/Molecules/InputFileItemCircularImage.vue";
import { mount } from "@vue/test-utils";

describe("InputFileItemCircularImageコンポーネントテスト", () => {
  test("props validationName", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const inputFileComponent = wrapper.getComponent(InputFile);

    // InputFileコンポーネントはprops validationName「test_validationName」を持つこと
    expect(inputFileComponent.props().validationName).toBe(options.props.validationName);
  });
  test("props accept", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        accept: "test_accept",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const inputFileComponent = wrapper.getComponent(InputFile);

    // InputFileコンポーネントはprops accept「test_accept」を持つこと
    expect(inputFileComponent.props().accept).toBe(options.props.accept);
  });
  test("props label", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        label: "test_label",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const actualText = wrapper.text();

    // コンテンツ「test_label」を挿入すること
    expect(actualText).toContain(options.props.label);
  });
  test("props src", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        src: "storege/test.jpg",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const circularImageComponent = wrapper.getComponent(CircularImage);

    // CircularImageコンポーネントはprops src「storege/test.jpg」を持つこと
    expect(circularImageComponent.props().src).toBe(options.props.src);
  });
  test("error event", async () => {
    const options = {
      global: {
        stubs: {
          InputFile: true,
        },
      },
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const inputFileComponent = wrapper.getComponent(InputFile);
    const expected = "test error";
    await inputFileComponent.vm.$emit("error", expected);
    const actualText = wrapper.text();

    // エラーイベントが発火すると、エラーメッセージ「test error」を表示すること
    expect(actualText).toContain(expected);
  });
  test("change event", async () => {
    const options = {
      global: {
        stubs: {
          InputFile: true,
        },
      },
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const inputFileComponent = wrapper.getComponent(InputFile);
    const expected = "encoded_file_data";
    await inputFileComponent.vm.$emit("change", expected);
    const actualSrc = wrapper.getComponent(CircularImage).props().src;

    // チェンジイベントが発火すると、CircularImageコンポーネントはprops src「encoded_file_data」を持つこと
    expect(actualSrc).toBe(expected);
  });
  test("cancel event", async () => {
    const options = {
      global: {
        stubs: {
          InputFile: true,
        },
      },
      props: {
        validationName: "test_validationName",
        src: "storege/test.jpg",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const inputFileComponent = wrapper.getComponent(InputFile);
    await inputFileComponent.vm.$emit("cancele");
    const actualSrc = wrapper.getComponent(CircularImage).attributes().src;

    // キャンセルイベントが発火すると、CircularImageコンポーネントはprops src「storege/test.jpg」を持つこと
    expect(actualSrc).toBe(options.props.src);
  });
  test("props optionalIconIsShown default false", () => {
    const options = {
      props: {
        validationName: "test_validationName",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const actualExists = wrapper.findComponent(OptionalIcon).exists();

    // OptionalIconコンポーネントを表示しないこと
    expect(actualExists).toBeFalsy();
  });
  test("props optionalIconIsShown true", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        optionalIconIsShown: true,
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const actualExists = wrapper.getComponent(OptionalIcon).exists();

    // OptionalIconコンポーネントを表示すること
    expect(actualExists).toBeTruthy();
  });
  test("props alt", () => {
    const options = {
      props: {
        validationName: "test_validationName",
        alt: "test_alt",
      },
    };
    const wrapper = mount(InputFileItemCircularImage, options);
    const actualAlt = wrapper.getComponent(CircularImage).props().alt;

    // CircularImageコンポーネントはprops alt「test_alt」を持つこと
    expect(actualAlt).toBe(options.props.alt);
  });
});
