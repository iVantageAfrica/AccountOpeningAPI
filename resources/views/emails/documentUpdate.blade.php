@extends('emails.mailContainer')
@section('mailContent')

    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
            Dear <b>{{ $name }} </b><br>We hope you are doing well.
            <br />
            As part of our compliance and account validation process, we kindly request that you
            submit
            the required <b>supporting documentation</b> for your account.
            <br>
            This helps us ensure that your account remains compliant with regulatory standards
            and
            continues to function without interruption.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Please use the secure link below to upload the necessary documents: <br>


            <a href="{{ $url }}" style=" color:#DE4F01; padding-left: 30px;">
                {{ Str::limit($url, 60) }}
            </a>
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 20px 0px;">
            Kindly ensure that all documents submitted are valid, clear, and up to date. <br>
            If you require any assistance, our support team is available to guide you through the process. <br>
            Thank you for your cooperation and continued patronage.
        </p>


        <p style="line-height: 30px; font-size: 16px; margin-top: 30px;">
            <b>Security Notice:</b> <br>
            For your protection, please observe the following:
        </p>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;">Do not share your passwords, PINs, or One-Time Passwords (OTPs) with anyone.</li>
            <li style="margin-bottom: 5px;"> Always access banking links from trusted devices and secure networks. </li>
            <li style="margin-bottom: 5px;">Confirm that any webpage you access begins with “https://” before entering your information.</li>
            </li>
            <li style="margin-bottom: 5px;">If you receive any suspicious communication, kindly report it immediately to CustomerSupport@imperialmortgagebank.com</li>
        </ul>


        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 40px;">If
            you
            have any questions or require clarification, please contact our Customer
            Support
            Team on
            <a href="mailto:customercare@imperialmortgagebank.com." style=" color:#DE4F01">
                customercare@imperialmortgagebank.com.</a>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">Thank you for your
            cooperation and support.
        </p>
    </div>
@endsection
