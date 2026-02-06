@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
            Dear <b>{{ $refereeName }} </b><br>Warm greetings from <b>Imperial Homes Mortgage
                Bank.</b>
            <br />
            You have been nominated as a referee by {{ $accountName }} in support of a
            {{ $accountType }} opening request with our bank.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>Applicant Details</b>
        </p>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;"><b>Applicant Name: </b> {{ $accountName }}</li>
        </ul>

        @if($accountTypeId === 4 )
            <p style="line-height: 30px; font-size: 16px; margin: 0;">This request is in line
                with regulatory requirements and forms part of our customer due
                diligence process. </p>

            <p style="line-height: 30px; font-size: 16px; margin: 0;">
                <b>Applicant Details</b>
            </p>
            <ul style="margin-top: 0px;">
                <li style="margin-bottom: 5px;"><b>Applicant Name: </b> {{ $accountName }}</li>
                <li style="margin-bottom: 5px;"><b>Account Type Applied For: </b>
                    {{ $accountType }}</li>
                <li style="margin-bottom: 5px;"><b>Proposed Account Number: </b>
                    {{ $accountNumber }}</li>
            </ul>
        @endif

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>What Is Required from You </b> <br>
            Kindly assist by completing the reference form, which will require you to
        </p>
        <ul style="margin-top: 0px;">
            <li style="margin-bottom: 5px;">Confirm your basic details </li>
            <li style="margin-bottom: 5px;">Provide your bank account information </li>
            <li style="margin-bottom: 5px;">Submit a brief comment on the applicant
            </li>
            <li style="margin-bottom: 5px;">Upload your signature</li>
        </ul>

        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
            <b>Click the link below to complete the reference form:</b> <br>
            <a href="{{ $accountReferenceUrl }}" style="color:#DE4F01">
                {{ Str::limit($accountReferenceUrl, 90) }}
            </a>
            <br>
            Please note that this link is <b>secure and unique </b>to you.
        </p>

        <p style="line-height: 30px; font-size: 16px; margin: 0;">
            <b>Important Information </b>
        </p>
        <ul style="margin-top: 0px;">
            @if($accountTypeId === 4 )
                <li style="margin-bottom: 5px;">This request is part of CBN-mandated KYC and
                    onboarding requirements </li>
            @endif
            <li style="margin-bottom: 5px;">The information you provide will be treated
                with
                strict confidentiality </li>
            <li style="margin-bottom: 5px;">Failure to complete this reference may delay
                the
                applicant’s account activation </li>
        </ul>




        <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">If
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
