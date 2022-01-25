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