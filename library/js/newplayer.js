var footerplayerElement = document.querySelector('.footer-player .pause-button');
var PlayerTop = document.querySelector('.playlist-buttons-resume-pause');
var AudioElement = document.querySelector('Audio');
var currentTimeDisplay = document.querySelector('.player-time.current');
var TotalTimeDisplay = document.querySelector('.player-time.total');
const timeline = document.querySelector(".track");
const Series_list = document.querySelectorAll('.series_list');
Audiowaspaused = false;
Players = [footerplayerElement, PlayerTop];
Players.forEach(element => {
    element.addEventListener('click', function (e) {
        toggleplay(footerplayerElement, PlayerTop);
    })
});
function toggleplay(parent, parentO) {
    parent.classList.toggle('play');
    parentO.classList.toggle('play');

    if (parent.classList.contains('play')) {
        AudioElement.play();

    } else {
        AudioElement.pause();
        Audiowaspaused = true;
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
    totalTrack = AudioElement.duration;
    CurrentVal = 100 * value / totalTrack;
    timeline.value = CurrentVal;


}
AudioElement.addEventListener('canplay', function () {
    AudioCanPlayFunction();
})
AudioElement.addEventListener('error', function () {
    Error_play();
})

function AudioCanPlayFunction() {
    document.querySelector('.footer-player').classList.remove('load');
    if (footerplayerElement.classList.contains('play')) {
        AudioElement.play();
    }

}

function Error_play() {
    alert('Cannot find this specific audio try another sermon, our team is working on fixing the issue')
}

timeline.addEventListener('input', function (e) {
    TotalAudioLength = AudioElement.duration;
    Calc_current = e.target.value * TotalAudioLength / 100;
    currentTimeDisplay.textContent = ConversionTime(Calc_current);
    AudioElement.currentTime = Calc_current;
    if (Audiowaspaused) {
        AudioElement.play();
        Audiowaspaused = false;
    }
})
AudioElement.addEventListener("timeupdate", (e) => {
    TotalAudioLength = AudioElement.duration;
    AverageCast = 150;
    AudioLength = AudioElement.duration - AverageCast;
    currentTimeDisplay.textContent = ConversionTime(AudioElement.currentTime);
    TotalTimeDisplay.textContent = ConversionTime(TotalAudioLength);

    trace(AudioElement.currentTime);
    if (AudioElement.currentTime == AudioElement.duration) {
        toggleplay(footerplayerElement, PlayerTop);
    }

});
if (Series_list.length > 0) {
    Series_list.forEach(element => {
        element.addEventListener('click', function () {
            document.querySelector('.footer-player').classList.add('load');
            try {
                element.classList.add('active');
                if (!Audiowaspaused) {
                    AudioElement.pause();
                }
                SourceOrigin = element.querySelector('.origin').textContent;
                Series_list.forEach(element_r => {
                    if (element !== element_r && element_r.classList.contains('active')) {
                        element_r.classList.remove('active');
                    }
                });

                AudioElement.src = SourceOrigin;
            } catch (e) {
                console.log(e);
            }

        })
    })
}
TotalAudioLength = AudioElement.duration;
currentTimeDisplay.textContent = ConversionTime(AudioElement.currentTime);
TotalTimeDisplay.textContent = ConversionTime(TotalAudioLength);