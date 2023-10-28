import { validatePriceIncludingTax, validateReleasedAt } from "@/Modules/validation";

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

  test("発売日が空の場合は「発売日は必須項目です」を返すこと", () => {
    const actual = validateReleasedAt("");

    expect(actual).toBe("発売日は必須項目です");
  });
  test("境界値。発売日が今日の場合は「false」を返すこと。", () => {
    const actual = validateReleasedAt(new Date());

    expect(actual).toBeFalsy();
  });
  test("境界値。発売日が明日の場合は「発売日は今日以前の日付を指定してください。」を返すこと。", () => {
    const date = new Date();
    date.setDate(date.getDate() + 1);
    const actual = validateReleasedAt(date);

    expect(actual).toBe("発売日は今日以前の日付を指定してください。");
  });
});
