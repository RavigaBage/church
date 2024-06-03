const mainDiv = document.querySelector(".timer_set");
const DayEle = mainDiv.querySelector(".day");
const HourEle = mainDiv.querySelector(".hour");
const MinuteEle = mainDiv.querySelector(".min");
const SecondEle = mainDiv.querySelector(".second");

Value_Check = 10;

const IntervalSet = setInterval(() => {
  EndDate = new Date();
  Cnt = 24 * 60 * 60 * 1000;
  DaysTime = EndDate / Cnt;
  HoursTime = DaysTime * 24;

  MinTime = HoursTime * 60;
  SecondTime = MinTime * 60;

  Backwards_24 = Math.floor(24 - (HoursTime % 24));
  Backwards_minute = Math.floor(60 - (MinTime % 60));
  Backwards_second = Math.floor(60 - (SecondTime % 60));
  HourEle.innerText = `${Backwards_24}hr`;
  MinuteEle.innerText = `${Backwards_minute}min`;
  SecondEle.innerText = `${Backwards_second}sec`;
  Value_Check = Backwards_24;
  if (Value_Check == 0) {
    clearInterval(IntervalSet);
  }
}, 500);

function generateToken() {
  TimeDate = new Date().getTime();
  TotalNum = 10;
  ArrayTime = String(Math.random()).split("");
  NewArray = ArrayTime.filter((ele) => {
    if (ele != "." && ele != "0") {
      return ele;
    }
  });
  Letters = [
    "a",
    "b",
    "c",
    "d",
    "e",
    "f",
    "g",
    "h",
    "i",
    "j",
    "k",
    "l",
    "m",
    "n",
    "o",
    "p",
    "q",
    "r",
    "s",
    "t",
    "u",
    "v",
    "w",
    "x",
    "y",
    "z",
  ];
  Identification_num = "";
  console.log(ArrayTime);
  for (let i = 0; i < TotalNum; i++) {
    if (i % 2 == 1) {
      Identification_num += `<span>${Letters[NewArray[i]]}</span>`;
    } else {
      Identification_num += `<span>${NewArray[i + 1]}</span>`;
    }
  }
  document.querySelector(".tokenData div").innerHTML =
    "  " + Identification_num.toUpperCase();
}
document.querySelector(".token button").addEventListener("click", function () {
  generateToken();
  console.log("mana");
});
