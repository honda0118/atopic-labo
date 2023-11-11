import { validatePriceIncludingTax } from "@/Modules/validation";

describe("validation.jsをテスト", () => {
  test("境界値。税込価格が10万円以下の場合は「false」を返すこと。", () => {
    const actual = validatePriceIncludingTax(100000);

    expect(actual).toBeFalsy();
  });
  test("境界値。税込価格が10万円を超えた場合は「税込価格は10万円以下で指定してください。」を返すこと。", () => {
    const actual = validatePriceIncludingTax(100001);

    expect(actual).toBe("税込価格は10万円以下で指定してください。");
  });
  test("税込価格が空の場合は「税込価格は必須項目です」を返すこと", () => {
    const actual = validatePriceIncludingTax("");

    expect(actual).toBe("税込価格は必須項目です");
  });
  test("税込価格が正の整数ではない場合は「税込価格は正の整数を指定してください。」を返すこと", () => {
    const actual = validatePriceIncludingTax("011");

    expect(actual).toBe("税込価格は正の整数を指定してください。");
  });
});
