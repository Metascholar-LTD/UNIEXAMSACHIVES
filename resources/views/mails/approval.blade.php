<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Successfully Approved - University Exams Archive System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Georgia, Times, 'Times New Roman', serif;
            background-color: #ffffff;
            color: #1a1a1a;
            line-height: 1.6;
            -webkit-text-size-adjust: 100%;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background-color: #f0f4f8;
            padding: 15px 20px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }
        .logo-section {
            margin-bottom: 0;
        }
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0;
        }
        .logo-image {
            height: 50px;
            width: auto;
            max-width: 250px;
        }
        .tagline {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 12px;
            color: #6b7280;
            font-weight: 500;
            margin-top: 5px;
        }
        .content {
            background-color: #f8fafc;
            padding: 0 30px 30px 30px;
        }
        .content-card {
            background-color: #f8fafc;
            border: none;
            border-radius: 0;
            padding: 20px 0;
            margin: 0;
            box-shadow: none;
        }
        .greeting {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            color: #000000;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .message {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            color: #000000;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        .approval-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #22c55e;
        }
        .approval-title {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 18px;
            font-weight: bold;
            color: #166534;
            margin-bottom: 10px;
            display: block;
        }
        .approval-message {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            color: #166534;
            line-height: 1.5;
        }
        .credentials-box {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #f59e0b;
        }
        .credentials-title {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 10px;
            display: block;
        }
        .credentials-message {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            color: #92400e;
            line-height: 1.5;
        }
        .next-steps {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .steps-title {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            font-weight: bold;
            color: #000000;
            margin-bottom: 10px;
            display: block;
        }
        .steps-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .steps-list li {
            font-family: Georgia, Times, 'Times New Roman', serif;
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #000000;
            line-height: 1.4;
            padding-left: 0;
            position: relative;
        }
        .steps-list li:last-child {
            margin-bottom: 0;
        }
        .steps-list li::before {
            content: "• ";
            position: static;
            font-weight: bold;
            color: #000000;
            font-size: 16px;
        }
        .cta-button {
            display: inline-block;
            background-color: #059669;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            font-family: Georgia, Times, 'Times New Roman', serif;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: left;
            border-top: none;
        }
        .footer-disclaimer {
            font-family: Georgia, Times, 'Times New Roman', serif;
            font-size: 16px;
            color: #333333;
            margin-top: 10px;
            line-height: 1.4;
        }
        @media (max-width: 600px) {
            .email-container {
                margin: 0 !important;
                max-width: 100% !important;
                width: 100% !important;
            }
            .header {
                padding: 10px 15px;
            }
            .content, .footer {
                padding: 20px;
            }
            .content-card {
                padding: 20px;
                margin: 10px 0;
            }
            .logo-image {
                height: 45px;
                max-width: 220px;
            }
            .cta-button {
                display: block;
                width: 100%;
                text-align: center;
                margin: 15px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <div class="logo">
                    <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1761222538/cug_logo_new_e9d6v9.jpg" alt="University Exams Archive System" class="logo-image" />
                </div>
                <div class="tagline">Excellence in Academic Digital Archiving</div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="content-card">
                <div class="greeting">Hi {{ $firstname }},</div>
                
                <div class="message">
                    Great news! Your account has been approved and you now have full access to our University Archival System.
                </div>
                
                <div class="approval-box">
                    <div class="approval-title">
                        🎉 Account Approved!
                    </div>
                    <div class="approval-message">
                        Your account has been successfully approved and activated. You can now log in and start using all the features of our digital archival system.
                    </div>
                </div>
                
                <div class="credentials-box">
                    <div class="credentials-title">
                        🔑 Your Login Credentials
                    </div>
                    <div class="credentials-message">
                        <strong>Email:</strong> {{ $email }}<br>
                        <strong>Temporary Password:</strong> {{ $temporaryPassword }}<br><br>
                        <span style="color: #92400e; background-color: #fef3c7; padding: 5px; border-radius: 3px; display: inline-block;">
                            ⚠️ Please change your password after your first login for security.
                        </span>
                    </div>
                </div>
                
                <div class="next-steps">
                    <div class="steps-title">
                        Getting Started
                    </div>
                    <ul class="steps-list">
                        <li>Log in to the system using your registered email and temporary password</li>
                        <li>Explore your dashboard to see available features and options</li>
                        <li>Change your password for security (recommended)</li>
                        <li>Upload and manage exam materials as needed</li>
                        <li>Contact support if you have any questions or need assistance</li>
                    </ul>
                </div>
                
                <div style="text-align: center;">
                    <a href="{{ url('/login') }}" class="cta-button">Login to Your Account</a>
                </div>
                
                <div style="text-align: left; margin: 15px 0;">
                    <p style="font-family: Georgia, Times, 'Times New Roman', serif; color: #000000; font-size: 16px; line-height: 1.4;">
                        Welcome to the University Exams Archive System! We're excited to work with you and look forward to your contributions to our digital archive.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-disclaimer">
                This email was sent to {{ $email }} because your account has been approved for our University Archival System. 
                If you didn't expect this approval, please contact us immediately.
            </div>
        </div>
    </div>
</body>
</html>
