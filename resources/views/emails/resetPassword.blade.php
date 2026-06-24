@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">

        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px;">
            Dear <b>{{ $userName }}</b>,
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0 0 16px;">
            We received a request to reset the password associated with your <b>Account Opening Admin Portal</b> profile.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0 0 16px;">
            To proceed with the password reset process, kindly use the One-Time Password (OTP) below:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 24px;">
            <tr>
                <td style="padding: 12px 16px; font-size: 15px; font-weight: 600; background-color: #f5f5f5; border: 1px solid #e0e0e0; width: 40%;">
                    Password Reset OTP
                </td>
                <td style="padding: 12px 16px; font-size: 28px; font-weight: 700; color: #DE4F01; letter-spacing: 8px; background-color: #f5f5f5; border: 1px solid #e0e0e0;">
                    {{ $otpCode }}
                </td>
            </tr>
            <tr>
                <td style="padding: 12px 16px; font-size: 15px; font-weight: 600; border: 1px solid #e0e0e0; width: 40%;">
                    OTP Validity
                </td>
                <td style="padding: 12px 16px; font-size: 15px; border: 1px solid #e0e0e0;">
                   5 minutes from the time of this email
                </td>
            </tr>
        </table>

        <p style="line-height: 30px; font-size: 16px; font-weight: 700; margin: 0 0 8px;">
            What You Need to Do
        </p>
        <ol style="font-size: 15px; line-height: 28px; margin: 0 0 24px; padding-left: 20px;">
            <li>Return to the <b>Account Opening Admin Portal</b>.</li>
            <li>Enter the OTP provided above in the designated field.</li>
            <li>Click <b>Proceed</b>.</li>
            <li>Create a new password.</li>
            <li>Confirm the new password.</li>
            <li>Submit your request to complete the password reset process.</li>
        </ol>

        <p style="line-height: 28px; font-size: 15px; margin: 0 0 24px; padding: 12px 16px; background-color: #fff8f6; border-left: 4px solid #DE4F01;">
            If you did not initiate this request, please <b>disregard this email immediately</b> and notify the
            <b>System Administrator</b> or <b>Information Security Team</b>.
        </p>

        <p style="line-height: 30px; font-size: 16px; font-weight: 700; margin: 0 0 8px;">
            Password Security Guidelines
        </p>
        <p style="line-height: 28px; font-size: 15px; margin: 0 0 8px;">
            To help protect your account and customer information, please ensure that your new password:
        </p>
        <ul style="font-size: 15px; line-height: 28px; margin: 0 0 24px; padding-left: 20px;">
            <li>Contains at least <b>8 characters</b>.</li>
            <li>Includes a combination of <b>uppercase letters</b>, <b>lowercase letters</b>, <b>numbers</b>, and <b>special characters</b>.</li>
            <li>Does not contain easily guessed information such as your name, username, date of birth, or staff ID.</li>
        </ul>

        <p style="line-height: 30px; font-size: 16px; font-weight: 700; margin: 0 0 8px;">
            Data Protection and Security Tips
        </p>
        <ul style="font-size: 15px; line-height: 28px; margin: 0 0 24px; padding-left: 20px;">
            <li>Never share your password or OTP with anyone, including colleagues or support personnel.</li>
            <li>Do not write your password in visible locations or store it in unsecured files.</li>
            <li>Avoid accessing the portal from public or shared devices.</li>
            <li>Report any suspicious activity or unauthorized access immediately.</li>
        </ul>

        <p style="line-height: 30px; font-size: 16px; margin: 0 0 25px;">
            Thank you for helping us maintain a secure banking environment.
        </p>

    </div>
@endsection
