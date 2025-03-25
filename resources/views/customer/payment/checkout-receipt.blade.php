<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt - TEL-A</title>
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
            background-color: #9333ea; /* Purple color from your theme */
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
        
        /* Receipt section */
        .receipt {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 25px;
            margin-top: 20px;
            background-color: #ffffff;
        }
        
        .receipt-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
        }
        
        .total-row {
            font-weight: bold;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 16px;
        }
        
        /* Highlight color */
        .highlight {
            color: #9333ea; /* Purple color from your theme */
        }
        
        /* Thank you message */
        .thank-you {
            margin-top: 30px;
            text-align: center;
            font-size: 18px;
            color: #4b5563;
        }
        
        /* Button style */
        .button {
            display: inline-block;
            background-color: #9333ea;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 15px;
            text-align: center;
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
            margin-top: 15px;
            margin-bottom: 15px;
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
            
            .receipt {
                padding: 15px;
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
            <h1>Order Receipt</h1>
            <p>Receipt #{{ $receipt_number }}</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $customer_name }},</p>
            <p>Thank you for your order. We've received your downpayment and are processing your order right away. Please find your receipt details below:</p>
            
            <div class="receipt">
                <div class="receipt-header">
                    <h2 style="margin: 0; color: #1f2937;">RECEIPT</h2>
                    <p style="margin: 5px 0 0; color: #4b5563;">#{{ $receipt_number }}</p>
                    <p style="margin: 5px 0 0; color: #4b5563;">Date: {{ $date }}</p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <p style="margin-bottom: 8px;"><strong>Customer:</strong> {{ $customer_name }}</p>
                    <p style="margin-bottom: 8px;"><strong>Email:</strong> {{ $customer_email }}</p>
                    <p style="margin-bottom: 8px;"><strong>Order ID:</strong> {{ $order_id }}</p>
                    <p style="margin-bottom: 8px;"><strong>Production Company:</strong> {{ $production_company }}</p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <div class="receipt-row">
                        <span>Product:</span>
                        <span>{{ $apparel_type }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Production Type:</span>
                        <span>{{ $production_type }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Quantity:</span>
                        <span>{{ $quantity }} items</span>
                    </div>
                    <div class="receipt-row">
                        <span>Order Type:</span>
                        <span>{{ $is_bulk ? 'Bulk Order' : 'Single Order' }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Customization:</span>
                        <span>{{ $is_customized ? 'Personalized' : 'Standard' }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Downpayment:</span>
                        <span>₱{{ number_format($downpayment, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span>Total Price:</span>
                        <span>₱{{ number_format($total_price, 2) }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Balance Due (Upon Completion):</span>
                        <span>₱{{ number_format($balance_due, 2) }}</span>
                    </div>
                </div>
                
                <div class="thank-you">
                    <p>Thank you for your business!</p>
                    <a href="{{ route('customer.profile.orders') }}" class="button">Track Your Order</a>
                </div>
            </div>
            
            <p style="margin-top: 25px;">If you have any questions regarding this receipt or your order, please don't hesitate to contact our customer support team.</p>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="#">Instagram</a>
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
            </div>
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} TEL-A. All rights reserved.</p>
        </div>
    </div>
</body>
</html>