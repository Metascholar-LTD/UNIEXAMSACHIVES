<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
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
        .message p { margin: 0 0 12px 0; }
        .message ul { margin: 12px 0; padding-left: 20px; }
        .message ol { margin: 12px 0; padding-left: 20px; }
        .message h1, .message h2, .message h3 { margin: 16px 0 8px 0; }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .attachments {
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
            <div class="logo">University Exams Archive System</div>
            <div class="subject">{{ $subject }}</div>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>,</p>
            
            <p>The University Exams Archive System has sent you an official academic communication.</p>
            
            <div class="message">{!! $message !!}</div>
            
            @if($campaign->attachments && count($campaign->attachments) > 0)
                <div class="attachments">
                    <strong>📎 Document Attachments: {{ count($campaign->attachments) }} file(s) included</strong>
                    <p><small>Attachments are embedded within this email for your convenience.</small></p>
                </div>
            @endif
            
            <p>For academic inquiries, please contact the University administration office during business hours.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message from the University Exams Archive System.</p>
            <p>For technical support: <a href="mailto:support@academicdigital.space">support@academicdigital.space</a></p>
            <p><small>You are receiving this email as a registered user of the University Exams Archive System. 
               To manage your email preferences, please log into your account or contact the administrator.</small></p>
            <p>&copy; {{ date('Y') }} University Exams Archive System. All rights reserved.</p>
        </div>
    </div>
</body>
</html>