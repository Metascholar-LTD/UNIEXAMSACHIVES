<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
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
        .subject {
            color: #495057;
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .content {
            margin-bottom: 30px;
        }
        .message {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 4px solid #007bff;
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
        .user-info {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }
        .attachments {
            background-color: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
            border-radius: 5px;
        }
        .attachment-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
            padding: 10px;
            background-color: #ffffff;
            border-radius: 3px;
        }
        .attachment-icon {
            margin-right: 10px;
            color: #6c757d;
        }
        .attachment-details {
            flex: 1;
        }
        .attachment-name {
            font-weight: 600;
            color: #495057;
        }
        .attachment-size {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">University Exams Archive System</div>
            <div class="subject">{{ $subject }}</div>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
            
            <p>You have received an important message from the University Exams Archive System.</p>
            
            <div class="message">
                {!! nl2br(e($message)) !!}
            </div>
            
            @if($campaign->attachments && count($campaign->attachments) > 0)
                <div class="attachments">
                    <strong>📎 Attachments:</strong>
                    @foreach($campaign->attachments as $attachment)
                        <div class="attachment-item">
                            <div class="attachment-icon">
                                @if(str_contains($attachment['type'], 'pdf'))
                                    📄
                                @elseif(str_contains($attachment['type'], 'image'))
                                    🖼️
                                @elseif(str_contains($attachment['type'], 'zip'))
                                    📦
                                @else
                                    📎
                                @endif
                            </div>
                            <div class="attachment-details">
                                <div class="attachment-name">{{ $attachment['name'] }}</div>
                                <div class="attachment-size">{{ number_format($attachment['size'] / 1024, 1) }} KB</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <div class="user-info">
                <strong>Campaign Details:</strong><br>
                Sent to: {{ $user->email }}<br>
                Sent on: {{ now()->format('F j, Y \a\t g:i A') }}<br>
                Campaign ID: #{{ $campaign->id }}
            </div>
            
            <p>If you have any questions about this message, please contact our support team.</p>
            
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