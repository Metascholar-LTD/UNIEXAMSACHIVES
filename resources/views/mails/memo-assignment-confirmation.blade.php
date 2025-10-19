<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Assignment Confirmed</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            line-height: 1.5;
            color: #202124;
            background-color: #f8f9fa;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(60,64,67,0.3), 0 4px 8px 3px rgba(60,64,67,0.15);
        }
        
        .header {
            background: linear-gradient(135deg, #137333 0%, #34a853 100%);
            color: white;
            padding: 24px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 20px;
            font-weight: 500;
            margin: 0;
            letter-spacing: 0.25px;
        }
        
        .content {
            padding: 24px;
        }
        
        .greeting {
            font-size: 16px;
            margin-bottom: 16px;
            color: #202124;
        }
        
        .main-message {
            font-size: 14px;
            color: #5f6368;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        
        .success-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #e6f4ea;
            color: #137333;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
        }
        
        .memo-card {
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 16px;
            background-color: #fafafa;
        }
        
        .memo-subject {
            font-size: 16px;
            font-weight: 500;
            color: #1a73e8;
            margin-bottom: 8px;
            text-decoration: none;
        }
        
        .memo-subject:hover {
            text-decoration: underline;
        }
        
        .memo-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            font-size: 13px;
            color: #5f6368;
            margin-bottom: 12px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            background-color: #e6f4ea;
            color: #137333;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .assignee-section {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 16px;
        }
        
        .assignee-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #1a73e8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            font-size: 14px;
        }
        
        .assignee-info h4 {
            font-size: 14px;
            font-weight: 500;
            color: #202124;
            margin: 0 0 2px 0;
        }
        
        .assignee-info p {
            font-size: 12px;
            color: #5f6368;
            margin: 0;
        }
        
        .assignment-message {
            background-color: #e8f0fe;
            border-left: 3px solid #1a73e8;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 0 4px 4px 0;
        }
        
        .assignment-message p {
            font-size: 14px;
            color: #1a73e8;
            margin: 0;
            font-style: italic;
        }
        
        .notification-status {
            background-color: #e6f4ea;
            border-left: 3px solid #34a853;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 0 4px 4px 0;
        }
        
        .notification-status p {
            font-size: 14px;
            color: #137333;
            margin: 0;
        }
        
        .next-steps {
            background-color: #fef7e0;
            border-left: 3px solid #f9ab00;
            padding: 12px 16px;
            margin-bottom: 16px;
            border-radius: 0 4px 4px 0;
        }
        
        .next-steps h4 {
            font-size: 14px;
            font-weight: 500;
            color: #b06000;
            margin: 0 0 8px 0;
        }
        
        .next-steps ul {
            font-size: 13px;
            color: #5f6368;
            margin: 0;
            padding-left: 16px;
        }
        
        .next-steps li {
            margin-bottom: 4px;
        }
        
        .action-button {
            display: inline-block;
            background-color: #34a853;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.2s;
        }
        
        .action-button:hover {
            background-color: #137333;
            text-decoration: none;
            color: white;
        }
        
        .action-section {
            text-align: center;
            margin: 24px 0;
        }
        
        .footer {
            background-color: #f8f9fa;
            padding: 16px 24px;
            border-top: 1px solid #dadce0;
            text-align: center;
        }
        
        .footer p {
            font-size: 12px;
            color: #5f6368;
            margin: 0 0 4px 0;
        }
        
        .footer p:last-child {
            margin-bottom: 0;
        }
        
        .divider {
            height: 1px;
            background-color: #dadce0;
            margin: 16px 0;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .content {
                padding: 16px;
            }
            
            .header {
                padding: 16px;
            }
            
            .memo-meta {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>✅ Memo Assignment Confirmed</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello <strong>{{ $assigner->first_name }} {{ $assigner->last_name }}</strong>,
            </div>
            
            <div class="success-indicator">
                <span>✅</span>
                <span>Assignment completed successfully</span>
            </div>
            
            <div class="main-message">
                Your memo has been successfully assigned. The recipient has been notified and will receive an email to review the memo.
            </div>
            
            <div class="memo-card">
                <a href="{{ route('dashboard.uimms.chat', $memo->id) }}" class="memo-subject">
                    {{ $memo->subject }}
                </a>
                
                <div class="memo-meta">
                    <div class="meta-item">
                        <span>📄</span>
                        <span>Reference: {{ $memo->reference ?? 'N/A' }}</span>
                    </div>
                    <div class="meta-item">
                        <span>🕒</span>
                        <span>{{ now()->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="status-badge">Assigned</span>
                    </div>
                </div>
            </div>
            
            <div class="assignee-section">
                <div class="assignee-avatar">
                    {{ strtoupper(substr($assignee->first_name, 0, 1)) }}{{ strtoupper(substr($assignee->last_name, 0, 1)) }}
                </div>
                <div class="assignee-info">
                    <h4>{{ $assignee->first_name }} {{ $assignee->last_name }}</h4>
                    <p>{{ $assignee->department->name ?? 'Department not specified' }}</p>
                </div>
            </div>
            
            @if($assignmentMessage)
                <div class="assignment-message">
                    <p>"{{ $assignmentMessage }}"</p>
                </div>
            @endif
            
            <div class="notification-status">
                <p>📧 Email notification sent to <strong>{{ $assignee->first_name }} {{ $assignee->last_name }}</strong></p>
            </div>
            
            <div class="next-steps">
                <h4>What happens next:</h4>
                <ul>
                    <li>The assignee will receive an email notification</li>
                    <li>They'll be prompted to log in and review the memo</li>
                    <li>You can monitor progress in the system</li>
                    <li>All participants will be notified of updates</li>
                </ul>
            </div>
            
            <div class="divider"></div>
            
            <div class="action-section">
                <a href="{{ route('dashboard.uimms.chat', $memo->id) }}" class="action-button">
                    View Memo in System
                </a>
            </div>
            
            <div style="font-size: 12px; color: #5f6368; text-align: center; margin-top: 16px;">
                This is a confirmation email. The assignment has been successfully processed.
            </div>
        </div>
        
        <div class="footer">
            <p>University Advanced Communication System</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
