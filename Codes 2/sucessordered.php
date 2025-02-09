<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #f0f0f0;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: 200px auto;
            padding: 20px;
            background-color: #4CAF50; /* Green color for success */
            border-radius: 10px;
        }
        h1 {
            color: #fff;
        }
        .container p {
            color: #fff;
        }
        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #4CAF50; /* Green color */
            color: white;
            border-radius: 5px;
            z-index: 1000;
        }
        .popup.show {
            display: block;
        }
        .popup .close {
            cursor: pointer;
            float: right;
            font-weight: bold;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Congratulations!</h1>
        <p>You have placed your details are successfully stored.</p>
        <p>Check your mail box for further process</p>
        <a href="new home.html">Back to Home</a>
    </div>
</body>
</html>
