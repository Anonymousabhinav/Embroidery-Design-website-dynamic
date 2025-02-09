<script>
    function sendData() {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/login.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send("username=test&password=12345");
    }
</script>

<button onclick="sendData()">Send Data</button>
