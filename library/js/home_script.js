///////////////////Defining var,cons,let//////////////////
var Items = document.querySelectorAll(".item");
var Audio = document.querySelector("audio");
isPlaying = false;

function PlayAudio(ele) {
  Audio.play();
  isPlaying = true;
  Items.forEach((element) => {
    if (ele == element) {
      ele.classList.add("SnippetActive");
    } else {
      element.classList.remove("SnippetActive");
    }
  });
}
function checkSnippet(Item) {
  Audio.setAttribute("src", "snippets/" + Item.getAttribute("data-audio"));
  if (isPlaying == false) {
    if (Item.getAttribute("data-audio")) {
      PlayAudio(Item);
    }
  } else {
    Audio.pause();
    isPlaying = false;
    if (Item.getAttribute("data-audio")) {
      PlayAudio(Item);
    }
  }
}
Items.forEach((element) => {
  element.addEventListener("click", function () {
    checkSnippet(element);
  });
});
