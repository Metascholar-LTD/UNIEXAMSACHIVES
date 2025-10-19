<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Assigned to You</title>
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
            color: #007bff;
            font-size: 20px;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .memo-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
            border-radius: 5px;
        }
        .assignment-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-left: 4px solid #2196f3;
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
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .assignment-icon {
            font-size: 48px;
            color: #007bff;
            margin-bottom: 20px;
        }
        .assigner-info {
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">University Advanced Communication System</div>
            <div class="title">📋 Memo Assigned to You</div>
        </div>
        
        <div class="content">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="assignment-icon">📋</div>
            </div>
            
            <p>Dear <strong>{{ $assignee->first_name }} {{ $assignee->last_name }}</strong>,</p>
            
            <p>A memo has been assigned to you and requires your attention. Please log in to the system to review and respond.</p>
            
            <div class="memo-details">
                <h3 style="margin-top: 0; color: #007bff;">📄 Memo Details</h3>
                <p><strong>Subject:</strong> {{ $memo->subject }}</p>
                <p><strong>Reference:</strong> {{ $memo->reference ?? 'N/A' }}</p>
                <p><strong>Status:</strong> <span style="color: #ffc107; font-weight: bold;">Pending</span></p>
                <p><strong>Assigned Date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
            </div>
            
            <div class="assigner-info">
                <h4 style="margin-top: 0; color: #856404;">👤 Assigned By</h4>
                <p><strong>{{ $assigner->first_name }} {{ $assigner->last_name }}</strong></p>
                <p><em>{{ $assigner->department->name ?? 'Department not specified' }}</em></p>
            </div>
            
            @if($assignmentMessage)
                <div class="assignment-info">
                    <h4 style="margin-top: 0; color: #1976d2;">💬 Assignment Message</h4>
                    <p style="margin-bottom: 0;">{{ $assignmentMessage }}</p>
                </div>
            @endif
            
            <div style="background-color: #d1ecf1; padding: 15px; border-left: 4px solid #17a2b8; margin: 20px 0; border-radius: 5px;">
                <h4 style="margin-top: 0; color: #0c5460;">⚠️ Action Required</h4>
                <p style="margin-bottom: 0;">Please log in to the system to:</p>
                <ul style="margin-bottom: 0;">
                    <li>Review the full memo content and any attachments</li>
                    <li>Respond to the memo if required</li>
                    <li>Update the memo status as needed</li>
                    <li>Communicate with other participants</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('dashboard.uimms.chat', $memo->id) }}" class="button">View Memo in System</a>
            </div>
            
            <p style="margin-top: 30px;"><strong>Note:</strong> This is an automated notification. Please do not reply to this email. Use the system to communicate about this memo.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message from the University Advanced Communication System.</p>
            <p>Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} University Advanced Communication System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
