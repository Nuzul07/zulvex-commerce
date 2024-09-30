<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1c1c1c;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .header {
            font-size: 24px;
            color: #FFFFFF;
            margin-bottom: 20px;
            /* Google blue */
        }

        .otp {
            font-size: 36px;
            font-weight: bold;
            margin: 20px 0;
            color: #fbbc05;
            /* Google yellow */
        }

        .message {
            font-size: 16px;
            color: #FFFFFF;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #4285F4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
        }

        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 40px;
        }

        .footer a {
            color: #999;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .logo {
            background-color: #fbbc05;
            /* Yellow Google logo background */
            display: inline-block;
            padding: 10px;
            border-radius: 50%;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            A new sign-up on Zulvex
        </div>

        <div class="message">
            We noticed a new sign-up to your account.<br>
            This code is confidental, please do not share to anyone.<br>
            Your One Time Password (OTP).
        </div>

        <div class="otp">
            {{ $otp }}
        </div>

        <div class="message">
            <p>OTP code expires at 5 minutes</p>
        </div>

        <div class="footer">
            You received this email to let you continue to your account and services.<br>
            © 2024 Zulvex, Jakarta
        </div>
    </div>

</body>

</html>