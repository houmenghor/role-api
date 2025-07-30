<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333333;
        }

        .content {
            margin-top: 20px;
            font-size: 16px;
            color: #444444;
        }

        .otp-box {
            margin: 30px auto;
            background-color: #f0f4ff;
            color: #1a3f8b;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            padding: 15px 20px;
            border-radius: 6px;
            letter-spacing: 4px;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="header">
            <h1>Reset Your Password</h1>
        </div>

        <div class="content">
            <p>Hi,</p>
            <p>We received a request to reset your password. Use the OTP below to proceed. This code will expire in 15 minutes.</p>

            <div class="otp-box">{{ $otp }}</div>

            <p>If you didn’t request a password reset, you can safely ignore this email.</p>
            <p>Thanks,<br><strong>{{ config('app.name') }}</strong> Team</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
