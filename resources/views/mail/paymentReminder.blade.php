<!DOCTYPE html>
<html>
<head>
    <title>Payment Reminder</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #7c3aed;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
        }
        .order-info {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .payment-details {
            background-color: #f5f3ff;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #8b5cf6;
        }
        h1 {
            margin-top: 0;
            font-size: 24px;
        }
        h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        p {
            margin: 10px 0;
        }
        .btn {
            display: inline-block;
            background-color: #7c3aed;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #7c3aed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Payment Reminder</h1>
        </div>
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>We hope this email finds you well. Your order is ready for collection, but we noticed that there is still a balance due for your order.</p>
            
            <div class="order-info">
                <h2>Order Information</h2>
                <p><strong>Order Number:</strong> #{{ $orderNumber }}</p>
                <p><strong>Production Company:</strong> {{ $companyName }}</p>
            </div>
            
            <div class="payment-details">
                <h2>Balance Due</h2>
                <p>Your remaining balance is:</p>
                <p class="amount">PHP {{ number_format($balanceDue, 2) }}</p>
                <p>Please complete your payment to finalize your order and proceed with collection.</p>
            </div>
            
            <p>To make your payment, please click the button below:</p>
            
            <div style="text-align: center;">
                <a href="{{ $paymentLink }}" class="btn">Pay Now</a>
            </div>
            
            <p style="margin-top: 20px;">If you have any questions or concerns, please don't hesitate to contact us.</p>
            
            <p>Thank you for your business!</p>
            
            <p>Best regards,</p>
            <p><strong>{{ $companyName }}</strong><br>TeLA Print Hub</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TeLA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>