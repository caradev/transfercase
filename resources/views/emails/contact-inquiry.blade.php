<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #ea580c;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
        }
        .field-value {
            margin-top: 5px;
            padding: 10px;
            background-color: white;
            border-left: 3px solid #ea580c;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 10px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0;">New Contact Inquiry</h1>
        <p style="margin: 5px 0 0 0;">Transfercase Unlimited</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">From:</div>
            <div class="field-value">
                {{ $inquiry->name }}<br>
                <a href="mailto:{{ $inquiry->email }}" style="color: #ea580c;">{{ $inquiry->email }}</a>
                @if($inquiry->phone)
                    <br>
                    <a href="tel:{{ $inquiry->phone }}" style="color: #ea580c;">{{ $inquiry->phone }}</a>
                @endif
            </div>
        </div>

        @if($inquiry->subject)
            <div class="field">
                <div class="field-label">Subject:</div>
                <div class="field-value">{{ $inquiry->subject }}</div>
            </div>
        @endif

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="message-box">{{ $inquiry->message }}</div>
        </div>

        <div class="field">
            <div class="field-label">Received:</div>
            <div class="field-value">{{ $inquiry->created_at->format('F d, Y \a\t g:i A') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated message from your website contact form.</p>
        <p>You can reply directly to this email to respond to {{ $inquiry->name }}.</p>
    </div>
</body>
</html>

