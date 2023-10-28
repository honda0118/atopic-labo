import { isNowDateOrLess } from "@/Modules/date";

// 金額を検証する
export const validatePriceIncludingTax = (value) => {
  if (!value) {
    return "税込価格は必須項目です";
  }

  const regexp = new RegExp(/^[1-9][0-9]*$/);
  if (!regexp.test(value)) {
    return "税込価格は正の整数を指定してください。";
  }

  if (value > 100000) {
    return "税込価格は10万円以下で指定してください。";
  }
};

// 発売日を検証する
export const validateReleasedAt = (value) => {
  if (!value) {
    return "発売日は必須項目です";
  }

  if (isNowDateOrLess(value)) {
    return;
  }
  return "発売日は今日以前の日付を指定してください。";
};
