<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Denied - TEL-A</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }

        /* Container layouts */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* Header section */
        .header {
            background-color: #9333ea;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            margin: 5px 0 0;
            font-size: 16px;
        }

        /* Logo */
        .logo {
            margin-bottom: 15px;
            max-width: 120px;
        }

        /* Content section */
        .content {
            padding: 30px 25px;
        }

        /* Button style */
        .button {
            display: inline-block;
            background-color: #9333ea;
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 15px;
            text-align: center;
            font-size: 16px;
        }

        .button:hover {
            background-color: #7e22ce;
        }

        /* Security note */
        .security-note {
            background-color: #f8fafc;
            border-left: 4px solid #9333ea;
            padding: 12px 15px;
            margin: 25px 0;
            font-size: 14px;
        }

        /* Footer section */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 14px;
            color: #718096;
            background-color: #f8fafc;
        }

        /* Social links */
        .social-links {
            margin: 15px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #9333ea;
            text-decoration: none;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                width: 100%;
                border-radius: 0;
            }

            .content {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <!-- Logo (could be replaced with an image) -->
            <div style="text-align: center;">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;">
                    <rect width="80" height="80" rx="40" fill="white" />
                    <path d="M25 30H55M25 40H55M25 50H40" stroke="#9333ea" stroke-width="4" stroke-linecap="round" />
                </svg>
            </div>
            <h1>Your Registration Has Been Denied</h1>
        </div>
        <div class="content">
            <h2 style="color: #1f2937; margin-top: 0;">Hello {{ $name ?? 'User' }},</h2>
            <p>We regret to inform you that your registration with TEL-A has been denied.</p>
            <p><strong>Reason:</strong></p>
            {!! $reason !!}

            <p>If you believe this is an error or have any questions, please contact our support team.</p>
        </div>
        <div class="footer">
            <div class="social-links">
                <a href="#">Instagram</a>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
            </div>
            <p>If you have any questions, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} TEL-A. All rights reserved.</p>
        </div>
    </div>
</body>

</html>