
/* 
This function generates an animation in the received element that changes color 
to red. It is useful to get the attention of the user. Requires jQuery-animation
library.
*/

function redAlert(element){
    var initialColor = $(element).css("color");
    for (var i = 0; i < 3; i++) {
        $(element).animate({color: initialColor}, 150);
        $(element).animate({color: "red"}, 150);
    }
}