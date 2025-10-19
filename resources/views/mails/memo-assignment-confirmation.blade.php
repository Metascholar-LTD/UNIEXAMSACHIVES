<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memo Assignment Confirmed</title>
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
        .memo-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
            border-radius: 5px;
        }
        .assignment-info {
            background-color: #d4edda;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
            border-radius: 5px;
        }
        .assignee-info {
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
            <div class="logo">University Advanced Communication System</div>
            <div class="title">✅ Memo Assignment Confirmed</div>
        </div>
        
        <div class="content">
            <div style="text-align: center; margin-bottom: 20px;">
                <div class="success-icon">✅</div>
            </div>
            
            <p>Dear <strong>{{ $assigner->first_name }} {{ $assigner->last_name }}</strong>,</p>
            
            <p>Your memo assignment has been successfully completed. The assigned person has been notified and will receive an email to log in and review the memo.</p>
            
            <div class="memo-details">
                <h3 style="margin-top: 0; color: #28a745;">📄 Memo Details</h3>
                <p><strong>Subject:</strong> {{ $memo->subject }}</p>
                <p><strong>Reference:</strong> {{ $memo->reference ?? 'N/A' }}</p>
                <p><strong>Status:</strong> <span style="color: #ffc107; font-weight: bold;">Pending (Assigned)</span></p>
                <p><strong>Assignment Date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
            </div>
            
            <div class="assignee-info">
                <h4 style="margin-top: 0; color: #1976d2;">👤 Assigned To</h4>
                <p><strong>{{ $assignee->first_name }} {{ $assignee->last_name }}</strong></p>
                <p><em>{{ $assignee->department->name ?? 'Department not specified' }}</em></p>
                <p><strong>Email:</strong> {{ $assignee->email }}</p>
            </div>
            
            @if($assignmentMessage)
                <div class="assignment-info">
                    <h4 style="margin-top: 0; color: #155724;">💬 Your Assignment Message</h4>
                    <p style="margin-bottom: 0;">{{ $assignmentMessage }}</p>
                </div>
            @endif
            
            <div class="assignment-info">
                <h4 style="margin-top: 0; color: #155724;">📧 Notification Sent</h4>
                <p style="margin-bottom: 0;">An email notification has been sent to <strong>{{ $assignee->first_name }} {{ $assignee->last_name }}</strong> informing them about this assignment. They will be prompted to log in and review the memo.</p>
            </div>
            
            <div style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0; border-radius: 5px;">
                <h4 style="margin-top: 0; color: #856404;">ℹ️ What Happens Next</h4>
                <ul style="margin-bottom: 0;">
                    <li>The assignee will receive an email notification about this assignment</li>
                    <li>They will be prompted to log in and review the memo</li>
                    <li>You can monitor the memo's progress in the system</li>
                    <li>All participants will be notified of any updates or responses</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('dashboard.uimms.chat', $memo->id) }}" class="button">View Memo in System</a>
            </div>
            
            <p style="margin-top: 30px;"><strong>Note:</strong> This is a confirmation email. The assignment has been successfully processed and the assignee has been notified.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message from the University Advanced Communication System.</p>
            <p>Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} University Advanced Communication System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
