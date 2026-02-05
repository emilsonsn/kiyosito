u<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maintenance Mode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #ffffff;
            color: #333;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            flex-direction: column;
        }
        img {
            max-width: 300px;
            margin-bottom: 20px;
        }
        .message {
            max-width: 500px;
        }
    </style>
</head>
<body>
    <img src="{{ asset('assets/images/maintenance/maintenance.png') }}" alt="Maintenance Image">
    <div class="message">
        <h1>We'll be back soon!</h1>
        <p>Our site is currently undergoing scheduled maintenance.<br>Please check back shortly.</p>
    </div>
</body>
</html>

