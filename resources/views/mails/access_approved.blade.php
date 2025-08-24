<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Request Approved</title>
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
            border-bottom: 3px solid #10b981;
        }
        .logo {
            width: 80px;
            height: 80px;
            background-color: #10b981;
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
            color: #10b981;
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
        .highlight-box {
            background-color: #f0fdf4;
            border: 2px solid #10b981;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
        .highlight-text {
            color: #10b981;
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .next-steps {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .next-steps h3 {
            color: #374151;
            margin-top: 0;
            font-size: 18px;
        }
        .next-steps ul {
            margin: 15px 0;
            padding-left: 20px;
        }
        .next-steps li {
            margin-bottom: 8px;
            color: #4b5563;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #059669;
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">✓</div>
            <h1 class="title">Access Request Approved!</h1>
            <p class="subtitle">University Digital Archive System</p>
        </div>

        <div class="content">
            <div class="greeting">
                Dear <strong>{{ $firstname }}</strong>,
            </div>

            <div class="message">
                Great news! Your request for access to the <strong>Advance Communication System</strong> has been approved by our administrators.
            </div>

            <div class="highlight-box">
                <p class="highlight-text">🎉 Your access has been granted!</p>
            </div>

            <div class="message">
                You can now access the advance communication system using your existing account credentials at the admin portal.
            </div>

            <div class="next-steps">
                <h3>Next Steps:</h3>
                <ul>
                    <li>Visit the admin portal at: <strong>/admin</strong></li>
                    <li>Log in with your existing email and password</li>
                    <li>You'll now have access to the advance communication features</li>
                    <li>Explore the new capabilities available to you</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/admin') }}" class="button">Access Admin Portal</a>
            </div>

            <div class="message">
                If you have any questions about using the advance communication system or need assistance, please don't hesitate to contact our support team.
            </div>

            <div class="contact-info">
                <p><strong>Need Help?</strong></p>
                <p>Email: support@academicdigital.space</p>
                <p>System: University Digital Archive</p>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated message from the University Digital Archive System.</p>
            <p>Please do not reply to this email. For support, contact our team directly.</p>
        </div>
    </div>
</body>
</html>
