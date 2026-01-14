@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px; ">
            Dear <b>{{ $firstname }} </b><br>We are pleased to inform you that your account with Imperial Homes Mortgage bank has been successfully created. Here are your account details:
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">Account Number: <b>{{ $accountNumber }}</b> <br> Account Type: <b>{{ $accountType }}</b></p>
        <br />
        @if(!empty($accountReferenceUrl) &&  $accountTypeId === 1 )
        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">As part
            of completing your account setup, <b>please provide two bank account referees.</b>
            You can submit your bank references by clicking the link below:</p>
        <a href="{{ $accountReferenceUrl }}" style=" color:#DE4F01">{{ $accountReferenceUrl }}</a>
        <br><br>
        @endif

        @if(!empty($accountReferenceUrl) &&  $accountTypeId === 3 )
            <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">As part
                of completing your account setup, <b>please provide two bank account referees and upload your company documents.</b>
                Kindly click the link below to complete your setup:</p>
            <a href="{{ $accountReferenceUrl }}" style=" color:#DE4F01">{{ $accountReferenceUrl }}</a>
            <br><br>
        @endif

{{--        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">--}}
{{--            You can now access your account and continue with transactions securely through our internet banking platform. Simply log in with your registered credentials to view your account, make transfers, and manage your finances conveniently.--}}
{{--        </p>--}}
        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            For your security, please keep your account details confidential and ensure your login information is not shared with anyone.
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
