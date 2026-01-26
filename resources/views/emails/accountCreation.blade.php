@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 5px 0px;">
            Dear <b>{{ $firstname }} </b><br>
            Welcome to the <b>Imperial Homes Mortgage Bank.</b>
            <br />We are pleased to inform you that your {{ $accountType }} with Imperial Homes
            Mortgage Bank has been successfully opened.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>Account Details</b>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;"><b>Account Name: </b> {{ $customerName }}</li>
            <li style="margin-bottom: 5px;"><b>Account Number: </b> {{ $accountNumber }}</li>
            <li style="margin-bottom: 5px;"><b>Account Type: </b> {{ $accountType }}</li>
            <li style="margin-bottom: 5px;"><b>Date:</b> {{ date('Y-m-d') }}</li>
            <li style="margin-bottom: 5px;"><b>Time:</b> {{ date('H:i:s') }}</li>
        </ul>
        </p>

        @if(!empty($accountReferenceUrl) && $accountTypeId === 1 )
            <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
                As part of completing your account setup, <b>please provide two bank account referees.</b>
                You can submit your bank references by clicking the link below:
            </p>
            <a href="{{ $accountReferenceUrl }}" style="color:#DE4F01">
                {{ Str::limit($accountReferenceUrl, 20) }}
            </a>
            <br><br>
        @endif

        @if(!empty($accountReferenceUrl) &&  $accountTypeId === 3 )
            <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
                As part of completing your account setup, <b>please provide two bank account referees and upload your company documents.</b>
                Kindly click the link below to complete your setup:
            </p>
            <a href="{{ $accountReferenceUrl }}" style="color:#DE4F01">
                {{ Str::limit($accountReferenceUrl, 20) }}
            </a>
            <br><br>
        @endif

        @if($accountTypeId === 1 || $accountTypeId === 2 )
            <p style="line-height: 30px; font-size: 16px; margin: 0;">
                <b>Access to Digital Banking Services</b>
            </p>
            <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
                You now have instant access to our Internet Banking and Mobile Banking platforms, allowing
                you to conveniently manage your account and perform transactions anytime, anywhere.
                <br> <b>Your Login Details</b>
            </p>

            <ul style="margin-top: -15px;">
                <li style="margin-bottom: 5px;"><b>Username: </b> {{ $username }}</li>
                <li style="margin-bottom: 5px;"><b>Temporary PIN: </b> {{ $pin }}</li>
                <li style="margin-bottom: 5px;"><b>Temporary Password: </b> {{ $password }}</li>
            </ul>

            <p style="line-height: 30px; font-size: 16px; margin: 0;">
                Please proceed to log in via our <b>Internet Banking portal or Mobile App</b> using the credentials above.
                For security reasons, <b>you will be required to create a new login password and transaction PIN</b>
                on your first login.
            </p>
            <br><br>
        @endif

        @if($accountTypeId === 3)
            <p style="line-height: 30px; font-size: 16px; margin: 0;">
                <b>Important Notice on Digital Banking Access </b>
            </p>
            <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">Please
                proceed to register for our Corporate Internet Banking (CIB) platform by completing
                our
                On-boarding form <a
                    href="https://corporate.imperialmortgagebank.com/?nav_source=ibs"
                    style=" color:#DE4F01"> here</a>


            <p class="" style="line-height: 30px; font-size: 16px; margin: 0;">
                You can reach out to us on <a href="mailto:customercare@imperialmortgagebank.com"
                                              style=" color:#DE4F01"> customercare@imperialmortgagebank.com </a> for
                assistance.
            </p>
            <br><br>
        @endif

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>Important Security Notice</b>
        </p>
        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
            To protect your account
        </p>

        <ul style="margin-top:0px">
            <li style="margin-bottom: 5px;"><b>Do not share your password or transaction PIN with anyone</b></li>
            <li style="margin-bottom: 5px;">Imperial Homes Mortgage Bank staff will <b>never request</b> your password or PIN</li>
            <li>Always ensure you log in through our official banking channels only</li>
        </ul>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            If you suspect any unauthorized access or activity, please contact us immediately on
            customercare@imperialmortgagebank.com. <br><br>
            Thank you for choosing Imperial Homes Mortgage Bank. <br>
            We are committed to providing you with secure, reliable, and convenient banking services.
        </p>
    </div>
@endsection
