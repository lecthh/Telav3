<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            margin-top: 0;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            margin: 10px 0;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            font-size: 0.9em;
            color: #666;
            margin-top: 20px;
            text-align: center;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Hello {{$name}},</h1>
        <h2>Set Your Password</h2>
        <p>To set your password, please click the link below:</p>
        <p><a href="{{ $url }}" target="_blank">Set Your Password</a></p>
        <p>If you did not request this, please ignore this email.</p>
        <div class="footer">
            <p>Best regards,<br>The Tel-A Team</p>
            <p><a href="https://www.Tel-A.com">Visit our website</a></p>
        </div>
    </div>
</body>

</html>