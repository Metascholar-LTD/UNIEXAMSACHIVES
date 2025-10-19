<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Assigned to You</title>
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
            background: linear-gradient(135deg, #1a73e8 0%, #4285f4 100%);
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
            background-color: #fef7e0;
            color: #b06000;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .assigner-section {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 6px;
            margin-bottom: 16px;
        }
        
        .assigner-avatar {
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
        
        .assigner-info h4 {
            font-size: 14px;
            font-weight: 500;
            color: #202124;
            margin: 0 0 2px 0;
        }
        
        .assigner-info p {
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
        
        .action-button {
            display: inline-block;
            background-color: #1a73e8;
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
            background-color: #1557b0;
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
            <h1>📋 Memo Assigned to You</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello <strong>{{ $assignee->first_name }} {{ $assignee->last_name }}</strong>,
            </div>
            
            <div class="main-message">
                A memo has been assigned to you and requires your attention. Please review the details below and take the necessary action.
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
                        <span class="status-badge">Pending</span>
                    </div>
                </div>
            </div>
            
            <div class="assigner-section">
                <div class="assigner-avatar">
                    {{ strtoupper(substr($assigner->first_name, 0, 1)) }}{{ strtoupper(substr($assigner->last_name, 0, 1)) }}
                </div>
                <div class="assigner-info">
                    <h4>{{ $assigner->first_name }} {{ $assigner->last_name }}</h4>
                    <p>{{ $assigner->department->name ?? 'Department not specified' }}</p>
                </div>
            </div>
            
            @if($assignmentMessage)
                <div class="assignment-message">
                    <p>"{{ $assignmentMessage }}"</p>
                </div>
            @endif
            
            <div class="divider"></div>
            
            <div class="action-section">
                <a href="{{ route('dashboard.uimms.chat', $memo->id) }}" class="action-button">
                    View Memo in System
                </a>
            </div>
            
            <div style="font-size: 12px; color: #5f6368; text-align: center; margin-top: 16px;">
                This is an automated notification. Please do not reply to this email.
            </div>
        </div>
        
        <div class="footer">
            <p>University Advanced Communication System</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>
