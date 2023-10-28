import { isNowDateOrLess } from "@/Modules/date";

describe("date.jsをテスト", () => {
  test("比較日付が現在の日付以下の場合は「true」を返すこと", () => {
    const date = new Date();
    const actual = isNowDateOrLess(date);

    expect(actual).toBeTruthy();
  });
  test("比較日付が現在の日付より大きい場合は「false」を返すこと", () => {
    const date = new Date();
    date.setDate(date.getDate() + 1);
    const actual = isNowDateOrLess(date);

    expect(actual).toBeFalsy();
  });
});
