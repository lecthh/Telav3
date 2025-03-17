<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Design Has Been Finalized by Designer {{$Designer}}</title>
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
        }

        p {
            margin: 10px 0;
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
        <p>Good day! We are pleased to inform you that your order has been confirmed by {{$Designer}}.</p>
        <p>To view your design and add more details please <a href="{{$url}}" style="color: #4CAF50; font-weight: bold; text-decoration: underline;">click here</a>.</p>
        <p>If you did not request this, please ignore this email</p>
        <p>Thank you for choosing our service!</p>
        <div class="footer">
            <p>Best regards,<br>The Tel-A Team</p>
            <p><a href="https://www.Tel-A.com">Visit our website</a></p>
        </div>
    </div>
</body>

</html>