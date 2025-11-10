@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px; ">
            Thank you for choosing <b>Imperial Homes Mortgage Bank Limited. </b><br>We’re excited to have you on board and appreciate your interest in opening an account with us.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">To proceed with your account opening process, please use the One-Time Password (OTP) below to verify your identity:</p>
        <br />
        <p class="bold"
           style="margin-top: 0px; color: #DE4F01; font-weight: 700; line-height: 30px; font-size: 46px; letter-spacing: 10px; text-align: center;">
            {{ $otpCode }}
        </p>
        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: -15px;">
            This code is valid for the next 5 minutes. Please do not share it with anyone for security reasons.
        </p>
        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Have questions? Our support team is ready to help. Just reach out — we're here for
            you every step of the way!
        </p>
        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Welcome once again to <b>Imperial Homes Mortgage Bank Limited</b>, where we translate home ownership dreams into reality.
        </p>
    </div>
@endsection
