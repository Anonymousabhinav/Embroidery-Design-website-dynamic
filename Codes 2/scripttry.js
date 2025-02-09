function changeImage(selectedImage) {
    // Reset all images to default state
    const images = document.querySelectorAll('.gallery-image1, .gallery-image2, .gallery-image3, .gallery-image4');
    images.forEach(image => {
        image.classList.remove('active');
    });

    // Set the clicked image's parent (the image's container) to active state
    selectedImage.parentElement.classList.add('active');
}
