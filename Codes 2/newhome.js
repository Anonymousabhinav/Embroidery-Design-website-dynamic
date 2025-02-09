window.onscroll = function() {scrollFunction()};

var navbar = document.querySelector(".navbar");
var sticky = navbar.offsetTop;

function scrollFunction() {
if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky"); // Add sticky class when you scroll
    setTimeout(function() {
navbar.classList.add("sticky-active");
    }, 100); // Slight delay for smooth animation
} else {
    navbar.classList.remove("sticky");
    navbar.classList.remove("sticky-active");
}
}
