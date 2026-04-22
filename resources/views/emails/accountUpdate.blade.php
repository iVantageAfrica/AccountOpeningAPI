@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
            Dear <b>{{ $name }} </b><br>We hope you are doing well.
            <br />
            As part of our commitment to maintaining accurate records and delivering secure,
            seamless
            banking services, we kindly request that you update certain information associated
            with your
            account.

        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Please use the secure link below to access and update your account information: <br>


            <a href="{{ $url }}" style=" color:#DE4F01; padding-left: 30px;">
                {{ Str::limit($url, 60) }}
            </a>
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 20px 0px;">
            Kindly ensure that all information provided is complete, accurate, and reflects your
            current
            details. <br>
            If you require any assistance while completing this process, our support team will
            be pleased to
            assist you. <br>
            We appreciate your continued trust and cooperation.
        </p>


        <p style="line-height: 30px; font-size: 16px; margin-top: 30px;">
            <b>Security Notice:</b> <br>
            For your protection, please observe the following:
        </p>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;">Do not share your passwords, PINs, or One-Time
                Passwords (OTPs) with anyone.</li>
            <li style="margin-bottom: 5px;"> Always access banking links from trusted devices
                and secure networks. </li>
            <li style="margin-bottom: 5px;">Confirm that any webpage you access begins with
                “https://” before entering your information.</li>
            </li>
            <li style="margin-bottom: 5px;">If you receive any suspicious communication, kindly
                report it immediately to CustomerSupport@imperialmortgagebank.com</li>
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
