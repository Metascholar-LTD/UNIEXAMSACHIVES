<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Confirmation</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8fafc;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .email-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .email-header p {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .email-body {
            padding: 2rem;
        }
        
        .success-icon {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .success-icon svg {
            width: 64px;
            height: 64px;
            color: #10b981;
        }
        
        .email-content h2 {
            color: #1f2937;
            font-size: 1.4rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .email-content p {
            color: #6b7280;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .info-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .info-box h3 {
            color: #065f46;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .info-box p {
            color: #047857;
            margin: 0;
            text-align: left;
        }
        
        .security-notice {
            background-color: #fef3c7;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .security-notice h3 {
            color: #92400e;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
        
        .security-notice p {
            color: #b45309;
            margin: 0;
            text-align: left;
        }
        
        .login-button {
            text-align: center;
            margin: 2rem 0;
        }
        
        .login-button a {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .login-button a:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        .email-footer {
            background-color: #f9fafb;
            padding: 1.5rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            color: #6b7280;
            font-size: 0.9rem;
            margin: 0.5rem 0;
        }
        
        .contact-info {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
        }
        
        .contact-info p {
            color: #9ca3af;
            font-size: 0.8rem;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header,
            .email-body {
                padding: 1.5rem;
            }
            
            .email-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Password Reset Successful</h1>
            <p>Your account password has been updated</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <div class="email-content">
                <h2>Hello {{ $user->first_name }}!</h2>
                <p>This email confirms that your password for the University Digital Archive has been successfully reset.</p>
                
                <div class="info-box">
                    <h3>Reset Details:</h3>
                    <p><strong>Account:</strong> {{ $user->email }}</p>
                    <p><strong>Reset Time:</strong> {{ $timestamp }}</p>
                    <p><strong>Account Type:</strong> {{ $user->is_admin ? 'Regular User' : 'Administrator' }}</p>
                </div>
                
                <div class="security-notice">
                    <h3>Security Notice</h3>
                    <p>If you did not request this password reset, please contact our support team immediately. Your account security is important to us.</p>
                </div>
                
                <div class="login-button">
                    <a href="{{ route('frontend.login') }}">Login with New Password</a>
                </div>
                
                <p>You can now use your new password to access the University Digital Archive system.</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p><strong>University Digital Archive</strong></p>
            <p>Registry Communication System</p>
            
            <div class="contact-info">
                <p>This is an automated message. Please do not reply to this email.</p>
                <p>If you need assistance, please contact our support team.</p>
                <p>&copy; {{ date('Y') }} University Digital Archive. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
