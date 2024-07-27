define(function () {
  var CallMethods = {};
  Value_Check = 10;

  CallMethods.IntervalSet = (HourEle, MinuteEle, SecondEle, originValue) => {
    try {
      const IntervalData = setInterval(() => {
        if (isNaN(originValue)) {
          clearInterval(IntervalData);
        } else {
          OriginTime = new Date(parseInt(originValue));
          CurrentTime = new Date();
          Cnt = 24 * 60 * 60 * 1000;
          EndDate = new Date(parseInt(originValue) + Cnt) - CurrentTime;
          DaysTime = EndDate / Cnt;
          HoursTime = DaysTime * 24;
          MinTime = HoursTime * 60;
          SecondTime = MinTime * 60;
          Backwards_24 = Math.floor(HoursTime % 24);
          Backwards_minute = Math.floor(MinTime % 60);
          Backwards_second = Math.floor(SecondTime % 60);
          HourEle.innerText = `${Backwards_24}hr`;
          MinuteEle.innerText = `${Backwards_minute}min`;
          SecondEle.innerText = `${Backwards_second}sec`;
          Value_Check = Backwards_24;
          if (Value_Check <= 0) {
            clearInterval(IntervalData);
          }
        }
      }, 500);
    } catch (error) {
      console.log(error);
    }
  };

  CallMethods.generateToken = () => {
    try {
      TimeDate = new Date();
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
      for (let i = 0; i < TotalNum; i++) {
        if (i % 2 == 1) {
          Identification_num += `<span>${Letters[NewArray[i]]}</span>`;
        } else {
          Identification_num += `<span>${NewArray[i + 1]}</span>`;
        }
      }
      document.querySelector(".tokenData div").innerHTML =
        "  " + Identification_num.toUpperCase();
    } catch (error) {}
  };

  return CallMethods;
});
