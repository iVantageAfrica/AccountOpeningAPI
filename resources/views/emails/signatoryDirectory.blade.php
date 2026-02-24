@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px; ">
            Dear <b>{{ $name }} </b><br>
            Warm greetings from <b>Imperial Homes Mortgage Bank</b>, and welcome.
            <br>
            You have been listed as a {{ $type }} of <b>{{ $businessName }}</b>, which has
            applied to
            open a
            Corporate Account with our bank.
        </p>
        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">As part
            of our regulatory and compliance obligations, we are required to obtain basic KYC
            information for all company {!! $type === 'signatory'
                                    ? 'signatories' : 'directors' !!}.</p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>What Is Required from You </b> <br>
            Kindly complete a secure online KYC form by providing the following:
        </p>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;">Your basic personal details.</li>
            <li style="margin-bottom: 5px;">Valid means of identification.</li>
            <li style="margin-bottom: 5px;">BVN and NIN (as applicable)</li>
            <li style="margin-bottom: 5px;">Passport photograph and signature</li>
        </ul>

        <p class="details" style="line-height: 0px; font-size: 16px; padding-top: 20px;">
            <b>Click
                the link below to provide your KYC details:</b>
        </p>
        <a href="{{ $url }}" style="color:#DE4F01">
            {{ Str::limit($url, 100) }}
        </a>
        <br><br>
        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>Important Note </b>
        </p>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;">This request is mandatory under CBN KYC and AML/CFT
                regulations</li>
            <li style="margin-bottom: 5px;">All information provided will be handled
                confidentially and securely</li>
            <li style="margin-bottom: 5px;">Completion of this step is required for the
                successful onboarding of the corporate
                account </li>
        </ul>
        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
            If this information is not provided, the corporate account opening process may be
            delayed or
            suspended.<br>
            Should you require any assistance, please contact our team using the details below.
            Thank you for your cooperation.
        </p>

    </div>
@endsection
