document.getElementById('hamburger-menu').addEventListener('click', function() {
    var dropdown = document.getElementById('dropdown2-menu');
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
    } else {
        dropdown.style.display = 'block';
    }
});
