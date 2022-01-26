function getTheDate() {
    let today = new Date();
    let date = "" + (today.getMonth() + 1) + '/' + today.getDate() + '/' + (today.getFullYear());
    $('#date').html(date);
}

let timerID = null;
let timerRunning = false;

function stopClock() {
    if (timerRunning)
        clearTimeout(timerID);
    timerRunning = false;
}

function startClock() {
    stopClock();
    getTheDate();
    showTime();
}

function showTime() {
    let now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();
    let timeValue = '' + ((hours > 12) ? hours - 12 : hours);
    timeValue += ((minutes < 10) ? ':0' : ':') + minutes;
    timeValue += ((seconds < 10) ? ':0' : ':') + seconds;
    timeValue += (hours >= 12) ? ' P.M.' : ' A.M.';
    $('#clock').html(timeValue);
    timerID = setTimeout('showTime()', 1000);
    timerRunning = true;
}

$(document).ready(() => {
    $('#image-gallery img').mouseenter((e) => {
        $(e.currentTarget).animate({
            width: "85%",
        }, 'slow');
    });

    $('#image-gallery img').mouseleave((e) => {
        $(e.currentTarget).animate({
            width: "500px",
        }, 'slow');
    })
});