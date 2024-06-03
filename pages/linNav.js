const ContentDom = document.querySelector(".content_main");
const SkeletonDom = document.querySelector(".skeleton_loader");
const loader_progress = document.querySelector(".loader_progress");
var intVal = 0;
var IntervalSetAnimation;
script_motion = false;

const Urlroutes = {
  404: {
    template: "/pages/404.html",
    title: "404 | page not found",
    description: "404 page directions",
    script: "",
  },
  "/": {
    template: "",
    title: "404 | page not found",
    description: "404 page directions",
    script: "",
  },
  Dashboard: {
    template: "/pages/Dashboard.html",
    title: "Homepage screen | Router sequence",
    description: "hero",
    script: "",
  },
  Access_token: {
    template: "/pages/Access_token.html",
    title: "Homepage screen | Router sequence",
    description: "hero",
    script: "/pages/timer.js",
  },
};

async function fetchHtmlData(script_data) {
  if (script_data.length != "") {
    const htmlScript = await fetch(script_data, { method: "GET" });
    if (htmlScript.status == 200) {
      const response = await htmlScript.text();
      if (response) {
        if (!script_motion) {
          var Script_tag = document.createElement("script");
          Script_tag.setAttribute("id", "scriptId");
          Script_tag.innerHTML = response;
          document.head.appendChild(Script_tag);
          script_motion = true;
        }
      }
    }
  }
}
const locationHandler = async () => {
  try {
    var location = window.location.hash.replace("#", "");

    if (location.length == 0) {
      location = "/";
    }

    const route = Urlroutes[location] || Urlroutes[404];
    const html = await fetch(route.template, { method: "GET" });
    if (html.status == 200) {
      const response = await html.text();
      if (response) {
        if (script_motion) {
          const Scriptag = document.getElementById("scriptId");
          script_motion = false;
          console.log("acriptage");
        }

        document.querySelector("div.content_main").innerHTML = response;
        return route.script;
      }
    }
  } catch (error) {
    console.log(error);
  }
};

function setIntervalData() {
  IntervalSetAnimation = setInterval(() => {
    loader_progress.style.setProperty("--pr", intVal++);
  }, 90);
}
function ProgressLoader(val) {
  if (val == true) {
    if (loader_progress.classList.contains("active")) {
      setIntervalData();
    }
  } else {
    loader_progress.style.setProperty("--pr", 100);
    clearInterval(IntervalSetAnimation);
    loader_progress.style.setProperty("--pr", 0);
  }
}

function UrlTrace() {
  loader_progress.classList.add("active");
  ContentDom.classList.add("load");
  SkeletonDom.classList.add("load");
  setTimeout(() => {
    ProgressLoader(true);
  }, 100);
  locationHandler().then((data) => {
    console.log(data);
    fetchHtmlData(data);
    loader_progress.classList.remove("active");
    SkeletonDom.classList.remove("load");
    ContentDom.classList.remove("load");
    setTimeout(() => {
      ProgressLoader(false);
    }, 100);
  });
}
window.addEventListener("hashchange", function (e) {
  UrlTrace();
});
UrlTrace();
