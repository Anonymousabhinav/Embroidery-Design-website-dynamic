document.getElementById('myForm').addEventListener('submit', function(event) {
    var quantity = document.getElementById('quantity').value;
    
    // Check if the value is greater than 100
    if (quantity <= 100) {
        alert('Quantity must be greater than 100.');
        event.preventDefault(); // Prevent form submission
    }
});