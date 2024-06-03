var trigger = document.querySelector("#playList");
var menu = document.querySelector(".playList");
var closeBar = document.querySelector("#closeBar_play");
var Aud_speed = document.querySelector("#audioSpeed");
var playICon = document.querySelector(".icon_Main");
const timeline = document.querySelector(".track");
const scrubbingDiv = document.querySelector(".scrubbing");
const indicator = document.querySelector(".indicator");
var currentTimeDisplay = document.querySelector("#currentTime");
var TotalTimeDisplay = document.querySelector("#TotalTime");
var Audio = document.querySelector("audio");
var volume = document.querySelector("#volumeVal");
var spinner = document.querySelector(".spinner");
var spinnerImage = spinner.querySelector("img");
var item = document.querySelectorAll(".icon_download");
var DisplayName = document.querySelector(".playericon p");
function menuDisplayPlay() {
  menu.classList.add("active");
  console.log("df");
}
function togglePlay() {
  playICon.classList.toggle("active");
  if (playICon.classList.contains("active")) {
    spinner.classList.add("active");
  } else {
    spinner.classList.remove("active");
  }
}
function menuClosePlay() {
  menu.classList.remove("active");
}
count = 1;
function Speed() {
  value = parseInt(Aud_speed.getAttribute("data_value"));
  maxLimit = 2;
  minLimit = 0.5;
  if (count >= maxLimit) {
    count = minLimit;
  } else {
    count += 0.5;
  }
  Aud_speed.innerText = count + "x";
  Aud_speed.setAttribute("value", count);
  Audio.playbackRate = count;
}
let isScrubbing = false;
function scrubbing(e) {
  const rect = timeline.getBoundingClientRect();
  totalWidth = rect.width;
  if (e.type === "touchmove") {
    var touch = e.touches[0];
  } else {
    var touch = e.clientX;
  }
  ScrubWidth = (e.x || touch.clientX) - rect.x;
  currentPercent = (100 * ScrubWidth) / totalWidth;
  isScrubbing = (e.buttons & 1) === 1;
  cssWidth = currentPercent / 100;
  if (cssWidth > 1) {
  } else if (cssWidth < 0) {
  } else {
    timeline.style.setProperty("--preview-position", cssWidth);
  }
  if (isScrubbing) {
  } else {
    if (!wasPaused) Audio.currentTime = cssWidth * Audio.duration;
  }
}
let wasPaused;
function IndicatorUpdate(e) {
  const rect = timeline.getBoundingClientRect();
  if (e.type === "touchmove") {
    var touch = e.touches[0];
  } else {
    var touch = e.clientX;
  }
  totalWidth = rect.width;
  ScrubWidth = (e.x || touch.clientX) - rect.x;
  currentPercent = (100 * ScrubWidth) / totalWidth;
  cssWidth = currentPercent / 100;
  if (cssWidth > 1) {
  } else {
    scrubbingDiv.classList.add("IsScrubbing");
    scrubbingDiv.style.setProperty("--position-position", cssWidth);
  }

  if (isScrubbing) {
    e.preventDefault();
    if (cssWidth > 1) {
    } else if (cssWidth < 0) {
    } else {
      timeline.style.setProperty("--preview-position", cssWidth);
    }

    ///////////Updating time
  }
}
function ConversionTime(value) {
  hours = Math.floor(value / 3600);
  minutes = Math.floor((value % 3600) / 60);
  seconds = Math.floor((value % 3600) % 60);
  if (isNaN(minutes)) {
    minutes = "--";
    seconds = "--";
    hours = "--";
  }
  if (seconds < 10) {
    seconds = "0" + seconds;
  }
  if (hours == 0) {
    return `${minutes}` + `:` + `${seconds}`;
  } else {
    return `${hours}` + `:` + `${minutes}` + `:` + `${seconds}`;
  }
}
function trace(value) {
  const rect = timeline.getBoundingClientRect();
  totalWidth = rect.width;

  let AudioLength = Audio.duration;
  ValueIntoPixel = (totalWidth * value) / AudioLength;
  currentPercent = (100 * ValueIntoPixel) / totalWidth;

  cssWidth = currentPercent / 100;

  console.log(cssWidth === NaN);
  if (cssWidth > 1 || isNaN(cssWidth) == true) {
  } else if (cssWidth < 0) {
  } else {
    timeline.style.setProperty("--preview-position", cssWidth);
  }
}

Audio.addEventListener("timeupdate", (e) => {
  TotalAudioLength = Audio.duration;
  AverageCast = 150;
  AudioLength = Audio.duration - AverageCast;
  currentTimeDisplay.textContent = ConversionTime(Audio.currentTime);
  TotalTimeDisplay.textContent = ConversionTime(TotalAudioLength);

  trace(Audio.currentTime);
  // vidEpisodes.classList.add('active');ReplayInfo.classList.add('active');
  if (Audio.currentTime == Audio.duration) {
    playICon.classList.remove("active");
    spinner.classList.remove("active");
    for (let i = 0; i < item.length; i++) {
      const list = item[i];
      if (list.classList.contains("active")) {
        list.innerHTML = PlayIconEle;
        list.classList.remove("active");
        list.classList.add("played");
        PlayNext();
      }
    }
  }
});

function PlayNext(cmd) {
  console.log("err");
  for (let i = 0; i < item.length; i++) {
    const list = item[i];
    // if (list.classList.contains("active")) {   }
    if (i + 1 == item.length) {
    } else {
      NextItem = item[i + 1];
      NextItem.innerHTML = musicAnimation;
      PlayItem(NextItem);
      break;
    }
  }
}
let Audiowaspaused = false;
function changeIcon() {
  if (Audio.currentTime == Audio.duration) {
    togglePlay;
    Audio.pause();
  } else {
    if (!playICon.classList.contains("active")) {
      togglePlay();
      Audio.play();
      Audiowaspaused = false;
    } else {
      togglePlay();
      Audio.pause();
      Audiowaspaused = true;
    }
  }

  //////if playList was playing
  for (const list of item) {
    if (list.classList.contains("active")) {
      if (Audiowaspaused == true) {
        list.innerHTML = Pause;
      } else {
        list.innerHTML = musicAnimation;
      }
    }
  }
}

/////////////playlist//////////////////////////////////////////////////
volume.addEventListener("click", (e) => {
  if (Audio.volume == 0) {
    Audio.volume = 1;
  } else {
    Audio.volume = 0;
  }
});
musicAnimation = `<svg
xmlns="http://www.w3.org/2000/svg"
viewBox="0 0 55 80"
fill="#FFF"
>
<g transform="matrix(1 0 0 -1 0 80)">
  <rect width="10" height="20" rx="3">
    <animate
      attributeName="height"
      begin="0s"
      dur="4.3s"
      values="20;45;57;80;64;32;66;45;64;23;66;13;64;56;34;34;2;23;76;79;20"
      calcMode="linear"
      repeatCount="indefinite"
    />
  </rect>
  <rect x="15" width="10" height="80" rx="3">
    <animate
      attributeName="height"
      begin="0s"
      dur="2s"
      values="80;55;33;5;75;23;73;33;12;14;60;80"
      calcMode="linear"
      repeatCount="indefinite"
    />
  </rect>
  <rect x="30" width="10" height="50" rx="3">
    <animate
      attributeName="height"
      begin="0s"
      dur="1.4s"
      values="50;34;78;23;56;23;34;76;80;54;21;50"
      calcMode="linear"
      repeatCount="indefinite"
    />
  </rect>
  <rect x="45" width="10" height="30" rx="3">
    <animate
      attributeName="height"
      begin="0s"
      dur="2s"
      values="30;45;13;80;56;72;45;76;34;23;67;30"
      calcMode="linear"
      repeatCount="indefinite"
    />
  </rect>
</g>
</svg>`;
PlayIconEle = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
<path
  d="M16,10.27,11,7.38A2,2,0,0,0,8,9.11v5.78a2,2,0,0,0,1,1.73,2,2,0,0,0,2,0l5-2.89a2,2,0,0,0,0-3.46ZM15,12l-5,2.89V9.11L15,12ZM12,2A10,10,0,1,0,22,12,10,10,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z"
></path>
</svg>`;
Pause = `    <svg
class="icon--pressed"
role="presentation"
xmlns="http://www.w3.org/2000/svg"
viewBox="0 0 24 24">
<path
  d="M16,2a3,3,0,0,0-3,3V19a3,3,0,0,0,6,0V5A3,3,0,0,0,16,2Zm1,17a1,1,0,0,1-2,0V5a1,1,0,0,1,2,0ZM8,2A3,3,0,0,0,5,5V19a3,3,0,0,0,6,0V5A3,3,0,0,0,8,2ZM9,19a1,1,0,0,1-2,0V5A1,1,0,0,1,9,5Z"
></path>
</svg>`;
////initiating event listeners for playlist

function PlayItem(listH) {
  ////////////check and get required information
  for (const list of item) {
    if (list.classList.contains("active") && list != listH) {
      list.classList.remove("active");
      list.innerHTML = PlayIconEle;
      console.log("plo");
    }
  }
  let name = listH.getAttribute("data-name");
  let extension = listH.getAttribute("data-type");
  if (name || extension) {
    //////////////add to Audio
    Audio_src = Audio.getAttribute("src");
    source = Audio.querySelector("source");
    image = listH.getAttribute("data-img");
    Audio.setAttribute("src", "../Audio/" + name + "." + extension);
    source.setAttribute("src", "../Audio/" + name + "." + extension);
    source.setAttribute("type", "audio/" + extension);
    spinnerImage.setAttribute("src", "../images/artist/" + image);
    DisplayName.innerText = name;
    changeIcon();
  } else {
    alert("Problem occured");
    listH.innerHTML = PlayIconEle;
  }
}
for (const list of item) {
  list.addEventListener("click", function () {
    list.classList.add("active");
    list.innerHTML = musicAnimation;
    PlayItem(list);
  });
}

trigger.addEventListener("click", menuDisplayPlay);
Aud_speed.addEventListener("click", Speed);
playICon.addEventListener("click", changeIcon);
timeline.addEventListener("mousemove", (e) => {
  IndicatorUpdate(e);
});
timeline.addEventListener("mousedown", (e) => {
  scrubbing(e);
});
timeline.addEventListener("touchmove", (e) => {
  scrubbing(e);
});
document.addEventListener("mouseup", (e) => {
  if (isScrubbing) scrubbing(e);
});
document.addEventListener("mousemove", (e) => {
  if (isScrubbing) IndicatorUpdate(e);
});
document.addEventListener("mousemove", (e) => {
  if (isScrubbing) IndicatorUpdate(e);
});
document.addEventListener("touchmove", (e) => {
  if (isScrubbing) IndicatorUpdate(e);
});

closeBar.addEventListener("click", menuClosePlay);
timeline.addEventListener("mouseout", function () {
  scrubbingDiv.classList.remove("IsScrubbing");
  scrubbingDiv.style.setProperty("--position-position", 0);
});
