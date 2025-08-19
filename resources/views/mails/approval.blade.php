<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #28a745;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .title {
            color: #28a745;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .highlight {
            background-color: #d4edda;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #218838;
        }
        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">University Exams Archive System</div>
            <div class="title">Account Successfully Approved!</div>
        </div>
        
        <div class="content">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="success-icon">✅</div>
            </div>
            
            <p>Dear <strong>{{ $firstname }}</strong>,</p>
            
            <p>Great news! Your account has been successfully approved by our administrators.</p>
            
            <div class="highlight">
                <strong>Account Status: APPROVED</strong><br>
                Email: {{ $email }}<br>
                You can now access all features of the system.
            </div>
            
            <p>You can now:</p>
            <ul>
                <li>Log in to your account</li>
                <li>Access the dashboard</li>
                <li>Upload and manage exam materials</li>
                <li>Use all system features</li>
            </ul>
            
            <p>Welcome to the University Exams Archive System! We're excited to have you on board.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Login to Your Account</a>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated message from the University Exams Archive System.</p>
            <p>Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} University Exams Archive System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
