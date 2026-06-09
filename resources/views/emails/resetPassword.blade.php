@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px;">
            We received a request to reset your password for your <b>Imperial Homes Mortgage Bank Limited</b> account.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Use the One-Time Password (OTP) below to verify your identity and proceed with resetting your password:
        </p>

        <br />

        <p class="bold"
           style="margin-top: 0px; color: #DE4F01; font-weight: 700; line-height: 30px; font-size: 46px; letter-spacing: 10px; text-align: center;">
            {{ $otpCode }}
        </p>

        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: -15px;">
            This code is valid for the next 5 minutes. For your security, do not share this code with anyone.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            If you did not request a password reset, please ignore this email or contact our support team immediately.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Our support team is always available to assist you with any concerns.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Thank you for banking with <b>Imperial Homes Mortgage Bank Limited</b>.
        </p>
    </div>
@endsection
