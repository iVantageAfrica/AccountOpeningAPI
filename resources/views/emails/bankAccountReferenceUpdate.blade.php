@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
            Dear <b>{{ $name }} </b><br>We hope you are doing well.
            <br />
            To support our internal verification process and comply with regulatory
            requirements, we kindly
            request that you provide your account reference information.
            <br>
            This information is essential to validate your profile and ensure continued access
            to our banking
            services.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            Please use the secure link below to submit the required details: <br>


            <a href="{{ $url }}" style=" color:#DE4F01; padding-left: 30px;">
                {{ Str::limit($url, 90) }}
            </a>
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 20px 0px;">
            Kindly ensure that the information provided is accurate and verifiable. <br>Should
            you have any questions or require guidance, please do not hesitate to contact us.
            <br>Thank you for your cooperation.
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
