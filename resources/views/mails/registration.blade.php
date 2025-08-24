<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
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
            border-bottom: 2px solid #007bff;
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
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
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
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">University Exams Archive System</div>
            <div class="title">Registration Successful!</div>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $firstname }}</strong>,</p>
            
            <p>Welcome to the University Exams Archive System! Your registration has been completed successfully.</p>
            
            <div class="highlight">
                <strong>Account Details:</strong><br>
                Email: {{ $email }}<br>
                Status: Pending Approval
            </div>
            
            <p>Your account is currently pending approval by our administrators. You will receive another email once your account has been approved containing your login credentials.</p>
            
            <p><strong>What happens next?</strong></p>
            <ul>
                <li>Our administrators will review your registration</li>
                <li>Once approved, you'll receive an email with your login credentials</li>
                <li>You can then log in and start using the system</li>
            </ul>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Visit Our Website</a>
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
