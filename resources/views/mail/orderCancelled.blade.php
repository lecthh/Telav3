<!DOCTYPE html>
<html>
<head>
    <title>Order Cancellation Notice</title>
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
        .cancellation-info {
            background-color: #fee2e2;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
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
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Cancellation Notice</h1>
        </div>
        <div class="content">
            <p>Dear {{ $name }},</p>
            <p>We regret to inform you that your order has been cancelled.</p>
            
            <div class="order-info">
                <h2>Order Information</h2>
                <p><strong>Order Number:</strong> #{{ $orderNumber }}</p>
                <p><strong>Cancelled by:</strong> {{ $companyName }}</p>
            </div>
            
            <div class="cancellation-info">
                <h2>Cancellation Details</h2>
                <p><strong>Reason:</strong> {{ $reason }}</p>
                @if($reason == 'Other' && !empty($note))
                    <p><strong>Note:</strong> {{ $note }}</p>
                @endif
            </div>
            
            <p>If you have any questions or concerns regarding this cancellation, please don't hesitate to contact us.</p>
            
            <p>Thank you for your understanding.</p>
            
            <p>Sincerely,</p>
            <p>The TeLA Team</p>
            
            <a href="{{ url('/') }}" class="btn">Return to Website</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TeLA. All rights reserved.</p>
        </div>
    </div>
</body>
</html>