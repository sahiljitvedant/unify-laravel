<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Enquiry Confirmation</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:30px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border:1px solid #e0e0e0; border-radius:8px; padding:30px; text-align:center;">

          <!-- Logo -->
          <tr>
            <td style="padding-bottom:20px;">
              <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height:60px;">
  
            </td>
          </tr>

          <!-- Heading -->
          <tr>
            <td>
           
              <h3 style="color:#0B1061; margin-bottom:10px;">Hi {{ $name }},Thank You for Reaching Out!</h3>
              <p style="color:#555; font-size:15px; margin:0;">
                We have received your enquiry and will get back to you shortly.
              </p>
            </td>
          </tr>

          <!-- Request ID -->
          @if(!empty($requestId))
          <tr>
            <td style="padding:20px 0;">
              <p style="font-size:16px; font-weight:bold; color:#333; margin:0;">
                Your Request ID is: <span style="color:#0B1061;">{{ $requestId }}</span>
              </p>
            </td>
          </tr>
          @endif
        <!-- Enquiry Message -->
        @if(!empty($messageText))
            <tr>
                <td>
                <p style="color:#555; font-size:15px; margin:0;">
                    Your enquiry was about: <em>{{ $messageText }}</em>
                </p>
                </td>
            </tr>
        @endif

          <!-- Footer -->
          <tr>
            <td style="padding-top:30px; border-top:1px solid #e0e0e0;">
              <p style="font-size:13px; color:#888; margin:0;">
                ©2025 Sachii. All rights reserved.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>


