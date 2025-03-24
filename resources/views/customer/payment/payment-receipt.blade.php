<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        .content {
            padding: 20px;
        }
        .receipt {
            border: 1px solid #e2e8f0;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
        .receipt-header {
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-row {
            font-weight: bold;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #718096;
        }
        .highlight {
            color: #e67e22;
        }
        .thank-you {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; color: #2d3748;">Payment Receipt</h1>
            <p style="margin: 5px 0 0;">Receipt #{{ $receipt_number }}</p>
        </div>
        
        <div class="content">
            <p>Dear {{ $customer_name }},</p>
            <p>Thank you for your additional payment for Order #{{ $order_id }}. Please find your receipt below:</p>
            
            <div class="receipt">
                <div class="receipt-header">
                    <h2 style="margin: 0;">RECEIPT</h2>
                    <p style="margin: 5px 0 0;">#{{ $receipt_number }}</p>
                    <p style="margin: 5px 0 0;">Date: {{ $date }}</p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <p><strong>Customer:</strong> {{ $customer_name }}</p>
                    <p><strong>Email:</strong> {{ $customer_email }}</p>
                    <p><strong>Order ID:</strong> {{ $order_id }}</p>
                    <p><strong>Production Company:</strong> {{ $production_company }}</p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <div class="receipt-row">
                        <span>Original Quantity:</span>
                        <span>{{ $original_quantity }} items</span>
                    </div>
                    <div class="receipt-row highlight">
                        <span>Additional Quantity:</span>
                        <span>+ {{ $additional_quantity }} items</span>
                    </div>
                    <div class="receipt-row" style="font-weight: bold;">
                        <span>New Total Quantity:</span>
                        <span>{{ $new_total_quantity }} items</span>
                    </div>
                    <div class="receipt-row">
                        <span>Unit Price:</span>
                        <span>₱{{ number_format($unit_price, 2) }}</span>
                    </div>
                    <div class="receipt-row highlight">
                        <span>Additional Payment:</span>
                        <span>₱{{ number_format($additional_payment, 2) }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Payment Date:</span>
                        <span>{{ $payment_date }}</span>
                    </div>
                    <div class="total-row">
                        <span>New Total Price:</span>
                        <span>₱{{ number_format($total_price, 2) }}</span>
                    </div>
                    <div class="receipt-row">
                        <span>Balance Due (Upon Completion):</span>
                        <span>₱{{ number_format($balance_due, 2) }}</span>
                    </div>
                </div>
                
                <div class="thank-you">
                    <p>Thank you for your business!</p>
                </div>
            </div>
            
            <p style="margin-top: 20px;">If you have any questions regarding this receipt or your order, please contact our customer support.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>&copy; {{ date('Y') }} PrintShop. All rights reserved.</p>
        </div>
    </div>
</body>
</html>