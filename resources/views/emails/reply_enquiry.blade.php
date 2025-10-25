<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enquiry Reply</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">
    <p>Hello {{ $enquiry->name }},</p>

    <p><strong>Your query was:</strong></p>
    <blockquote style="background: #f8f9fa; padding: 10px; border-left: 3px solid #007bff;">
        {{ $enquiry->message }}
    </blockquote>

    <p><strong>Our reply:</strong></p>
    <blockquote style="background: #e9f7ef; padding: 10px; border-left: 3px solid #28a745;">
        {{ $enquiry->reply }}
    </blockquote>

    <p>Thank you for reaching out to us. If you have any further issues, kindly contact us again.</p>
    <p><em>Do not reply to this email as it is auto-generated.</em></p>

    <br>

    <p>Thanks for visiting,</p>
    <p><strong>Your regards,</strong><br>Sachi</p>
</body>
</html>
