// 現在の日付と比較する
export const isNowDateOrLess = (dateToCompare) => {
  const nowDate = new Date();
  const nowDateExceptTime = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate());

  const date = new Date(dateToCompare);
  const dateExceptTime = new Date(date.getFullYear(), date.getMonth(), date.getDate());

  if (dateExceptTime <= nowDateExceptTime) {
    return true;
  }
  return false;
};
