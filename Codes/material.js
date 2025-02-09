// JavaScript for synchronizing image and text in separate carousels
function initCarousel() {
    const images = document.querySelectorAll('#carousel1 .carousel-content');
    const texts = document.querySelectorAll('#carousel2 .text-content');
    let currentIndex = 0;

    function showNextContent() {
        images[currentIndex].classList.remove('active');
        texts[currentIndex].classList.remove('active');

        currentIndex = (currentIndex + 1) % images.length;

        images[currentIndex].classList.add('active');
        texts[currentIndex].classList.add('active');
    }

    // Add hover event listener to image carousel
    document.getElementById('carousel1').addEventListener('mouseenter', showNextContent);
}

// Initialize the carousel
initCarousel();
