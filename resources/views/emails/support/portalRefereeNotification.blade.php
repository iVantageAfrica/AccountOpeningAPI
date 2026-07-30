@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding: 0px 25px;">

        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px;">
            Dear <b>Support Team,</b><br />
            A new Bank Account Reference has been submitted successfully through the
            Customer Bank Reference Portal.
        </p>

        <!-- Account Holder Details -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 10px 0 10px;">
            Account Holder Details
        </p>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 0px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Name
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
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
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_holder_number }}</p>
                </td>

            </tr>
        </table>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">
            <tr>

                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Email
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
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
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Name
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->name }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Phone
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->mobile_number }}</p>
                </td>
            </tr>
        </table>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">
            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Email
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->email_address }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee
                        Address
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->address }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Bank
                        Name
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->bank_name }}</p>
                </td>

            </tr>
            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee
                        Account Name
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_name }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee
                        Account Number
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_number }}</p>
                </td>
            </tr>
            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Known Period
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->known_period }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Submitted
                        Date & Time
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->created_at?->format('Y-m-d H:i:s') }}</p>
                </td>
            </tr>
        </table>

        <!-- Comment -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 10px 0 10px;">
            Referee Comment
        </p>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 14px; font-weight: 500; margin: 0;">
                        {{ $refereeData->comment }}</p>
                </td>
            </tr>
        </table>

        <!-- What Is Required -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 20px 0 10px;">
            Required Action
        </p>

        <ul style="margin: 0 0 20px; padding-left: 20px;">
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Verify the completeness of the submitted Referee’s information</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Proceed to initiate reference suitability via the NIBSS E-reference portal</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Update the Imperial Account Holder status in the Core Banking System or Account Opening Portal as applicable</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Escalate any discrepancies where necessary</li>
        </ul>

        <!-- CTA Block -->
        <table role="presentation" style="width: 100%; margin: 0 0 20px;">
            <tr>
                <td
                    style="background-color: #FEF3ED; border-left: 3px solid #DE4F01; border-radius: 0 8px 8px 0; padding: 14px 16px;">
                    <p style="font-size: 14px; color: #5a2d13; margin: 0 0 10px;"><b>Kindly attend to the above as soon as possible.</b> <br> - Attached in this email is a summary of the referee's submission.</p>

                </td>
            </tr>
        </table>

    </div>
@endsection
