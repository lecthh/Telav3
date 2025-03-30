<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Design Has Been Finalized by Designer {{$Designer}}</title>
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
        
        /* Status card */
        .status-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 25px;
            margin: 20px 0;
            background-color: #f8fafc;
            text-align: center;
        }
        
        .status-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background-color: #9333ea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .status-title {
            font-size: 20px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        /* Button style */
        .button {
            display: inline-block;
            background-color: #9333ea;
            color: #ffffff;
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
            <h1>Design Confirmation</h1>
        </div>
        
        <div class="content">
            <h2 style="color: #1f2937; margin-top: 0;">Hello {{$name}},</h2>
            
            <p>Good news! We're pleased to inform you that your order design has been finalized by designer <strong>{{$Designer}}</strong>.</p>
            
            <div class="status-card">
                <div class="status-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <div class="status-title">Design Approved & Ready</div>
                <p>Your custom design has been finalized and is ready for your review.</p>
                <a href="{{$url}}" class="button">Confirm Your Design</a>
            </div>
            
            <p>After reviewing your design, you can provide additional details or approve it to move to production.</p>
            
            <p>If you have any questions about your design or next steps, feel free to reach out to our support team.</p>
            
            <p>Thank you for choosing TEL-A for your custom apparel needs!</p>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="#">Instagram</a>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
            </div>
            <p>If you did not request this, please ignore this email.</p>
            <p>&copy; {{ date('Y') }} TEL-A. All rights reserved.</p>
        </div>
    </div>
</body>
</html>