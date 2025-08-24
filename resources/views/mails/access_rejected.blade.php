<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Request Status</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #ef4444;
        }
        .logo {
            width: 80px;
            height: 80px;
            background-color: #ef4444;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .title {
            color: #ef4444;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin: 10px 0 0 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            color: #4b5563;
        }
        .status-box {
            background-color: #fef2f2;
            border: 2px solid #ef4444;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .status-text {
            color: #ef4444;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .reason-box {
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .reason-box h3 {
            color: #374151;
            margin-top: 0;
            font-size: 18px;
        }
        .reason-text {
            color: #4b5563;
            font-style: italic;
            margin: 0;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 6px;
            border-left: 4px solid #ef4444;
        }
        .next-steps {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .next-steps h3 {
            color: #0c4a6e;
            margin-top: 0;
            font-size: 18px;
        }
        .next-steps ul {
            margin: 15px 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin-bottom: 8px;
            color: #0c4a6e;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .contact-info {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .contact-info p {
            margin: 5px 0;
            color: #6b7280;
        }
        .appeal-info {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }
        .appeal-info p {
            margin: 5px 0;
            color: #92400e;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">ℹ</div>
            <h1 class="title">Access Request Status Update</h1>
            <p class="subtitle">University Digital Archive System</p>
        </div>

        <div class="content">
            <div class="greeting">
                Dear <strong>{{ $firstname }}</strong>,
            </div>

            <div class="message">
                Thank you for your interest in accessing the <strong>Advance Communication System</strong>. We have reviewed your request and unfortunately, we are unable to grant access at this time.
            </div>

            <div class="status-box">
                <p class="status-text">❌ Access Request Not Approved</p>
            </div>

            <div class="reason-box">
                <h3>Reason for Decision:</h3>
                <p class="reason-text">"{{ $reason }}"</p>
            </div>

            <div class="message">
                We understand this may be disappointing, but please know that this decision was made after careful consideration of your request and our system requirements.
            </div>

            <div class="next-steps">
                <h3>What You Can Do:</h3>
                <ul>
                    <li>Continue using your current account with existing features</li>
                    <li>Address any concerns mentioned in the reason above</li>
                    <li>Submit a new request in the future if circumstances change</li>
                    <li>Contact our support team for clarification if needed</li>
                </ul>
            </div>

            <div class="appeal-info">
                <p><strong>Have Questions?</strong></p>
                <p>If you believe this decision was made in error or have additional information to share, please contact our support team.</p>
            </div>

            <div class="contact-info">
                <p><strong>Need Support?</strong></p>
                <p>Email: support@academicdigital.space</p>
                <p>System: University Digital Archive</p>
            </div>

            <div class="message">
                Thank you for your understanding. We appreciate your interest in our system and hope to serve you better in the future.
            </div>
        </div>

        <div class="footer">
            <p>This is an automated message from the University Digital Archive System.</p>
            <p>Please do not reply to this email. For support, contact our team directly.</p>
        </div>
    </div>
</body>
</html>
