<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Your Password - TEL-A</title>
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
        
        /* Verification code box */
        .verification-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }
        
        .verification-code {
            font-family: monospace;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: 4px;
            color: #1f2937;
            margin: 10px 0;
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
            <!-- Logo could be an actual image in production -->
            <div style="text-align: center;">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin: 0 auto;">
                    <rect width="80" height="80" rx="40" fill="white"/>
                    <path d="M25 30H55M25 40H55M25 50H40" stroke="#9333ea" stroke-width="4" stroke-linecap="round"/>
                </svg>
            </div>
            <h1>Set Your Password</h1>
        </div>
        
        <div class="content">
            <h2 style="color: #1f2937; margin-top: 0;">Hello {{$name}},</h2>
            
            <p>Welcome to TEL-A! To complete your account setup, please set your password by clicking the button below:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $url }}" class="button">Set Your Password</a>
            </div>
            
            <p>Alternatively, you can copy and paste the following link into your browser:</p>
            <p style="word-break: break-all; font-size: 14px; color: #6b7280; background: #f1f5f9; padding: 10px; border-radius: 5px;">{{ $url }}</p>
            
            <div class="security-note">
                <strong>Security Note:</strong> This link will expire in 24 hours for your security. If you did not request this, please ignore this email and your account will remain secure.
            </div>
            
            <p>Thank you for choosing TEL-A for your custom apparel needs. We're excited to have you on board!</p>
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