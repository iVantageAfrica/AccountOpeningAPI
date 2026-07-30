@extends('emails.mailContainer')
@section('mailContent')

    <div style="padding: 0px 25px;">

        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px;">
            Dear <b>{{ $refereeData->account_holder_name }}</b><br />
            We wish to inform you that a referee has successfully completed and submitted your
            Bank Account
            Reference Form through the Imperial Homes Mortgage Bank Customer Bank Reference
            Portal as part
            of your account opening process.
        </p>

        <!-- Account Holder Details -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 10px 0 10px;">
            Submission Summary
        </p>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 0px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Name
                    </p>
                    <p style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_holder_name }}</p>
                </td>
            </tr>
        </table>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Number
                    </p>
                    <p style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_holder_number }}</p>
                </td>
            </tr>
        </table>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">
            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Email
                    </p>
                    <p style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_holder_email }}</p>
                </td>
            </tr>
        </table>

        <!-- Referee Details -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 10px 0 10px;">
            Referee Details
        </p>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 0px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Name
                    </p>
                    <p style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->name }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Known Period
                    </p>
                    <p style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->known_period }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Submitted Date
                        & Time
                    </p>
                    <p style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->created_at?->format('Y-m-d H:i:s') }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Comment
                    </p>
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">
                        {{ $refereeData->comment }}</p>
                </td>
            </tr>
        </table>



        <!-- What Is Required -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 20px 0 10px;">
            What Happens Next
        </p>
        <p style="line-height: 30px; font-size: 16px; margin: 0 0 16px;">
            Your reference has now been received and will undergo the following process:
        </p>

        <ul style="margin: 0 0 20px; padding-left: 20px;">
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Verification of
                the submitted reference information.</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Review of the
                referee's suitability comments.</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Update of your
                account opening application status.</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Account
                activation (where all onboarding requirements have been satisfied).</li>
        </ul>


        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 0px 0px 15px 0px;">
            Should additional information or clarification be required, a member of our Customer
            Management
            Team will contact you using your registered contact details.
        </p>

    </div>

@endsection
