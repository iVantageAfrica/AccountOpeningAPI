@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding: 0px 25px;">

        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px;">
            Dear <b>Support Team,</b><br />
            A customer has successfully submitted a Bank Reference Update request through the
            Customer
            Self-Service Portal.
        </p>

        <!-- Customer Details -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 10px 0 10px;">
            Account Summary
        </p>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 0px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Customer Name
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $accountData->user->full_name }}</p>
                </td>


            </tr>
        </table>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">


            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Email Address
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $accountData->user->email }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Phone Number
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $accountData->user->phone_number }}</p>
                </td>

            </tr>
            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Number
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $accountData->account_number }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Account Type
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $accountData->account_type_name }}</p>
                </td>
            </tr>

        </table>

        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 10px 0 10px;">
            Update Details
        </p>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 0px;">
            <tr>
                <td
                    style="width: 100%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">UPDATE TYPE
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        BANK REFERENCE UPDATE</p>
                </td>


            </tr>
        </table>
        <table role="presentation"
               style="width: 100%; border-collapse: separate; border-spacing: 8px; margin-left: -8px; margin-bottom: 12px;">


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
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Phone Number
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->phone_number ?? $refereeData->mobile_number ?? 'N/A' }}</p>
                </td>

            </tr>
            <tr>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Referee Account Number
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->account_number }}</p>
                </td>
                <td
                    style="width: 50%; background-color: #f4f4f5; border-radius: 8px; padding: 10px 12px; vertical-align: top;">
                    <p style="font-size: 12px; color: #8d91a0; margin: 0 0 2px;">Submitted Date & Time
                    </p>
                    <p
                        style="font-size: 14px; font-weight: 500; font-family: monospace; margin: 0;">
                        {{ $refereeData->created_at }}</p>
                </td>
            </tr>

        </table>


        <!-- What Is Required -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 20px 0 10px;">
            What Is Required from You
        </p>
        <p style="line-height: 30px; font-size: 16px; margin: 0 0 16px;">
            Kindly review the submitted referee information and proceed with the necessary verification
            process.
        </p>

        <!-- CTA Block -->
        <table role="presentation" style="width: 100%; margin: 0 0 20px;">
            <tr>
                <td
                    style="background-color: #FEF3ED; border-left: 3px solid #DE4F01; border-radius: 0 8px 8px 0; padding: 14px 16px;">
                    <p style="font-size: 14px; color: #5a2d13; margin: 0 0 10px;">Secure access
                        link — Can only be access with your administrative login details:</p>
                    <a href="https://accountopening.imperialmortgagebank.com/admin/auth"
                       style="color: #DE4F01; font-size: 14px; font-weight: 500; word-break: break-all;">
                        https://accountopening.imperialmortgagebank.com/admin/auth
                    </a>
                </td>
            </tr>
        </table>

        <p style="line-height: 28px; font-size: 14px; color: #8d91a0; margin: 0 0 8px;">To
            assist your review:</p>
        <ul style="margin: 0 0 20px; padding-left: 20px;">
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">A PDF summary of the submitted referee details is attached</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Any supporting documents provided by the customer are attached</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">The request can also be viewed from the customer management dashboard</li>
        </ul>

        <!-- Important Information -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 20px 0 10px;">
            Important Information
        </p>
        <ul
            style="margin: 0 0 24px; padding: 14px 14px 14px 34px; border: 1px solid #e5e5e5; border-radius: 8px;">
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">
                The referee information submitted forms part of the customer's account maintenance record</li>
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">All updates are logged and retained for audit and compliance purposes</li>
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">Verification should be completed before the customer's profile is updated on the Core Banking
                Application (CBA)</li>

        </ul>

        <p style="line-height: 30px; font-size: 16px; margin: 0 0 25px;">
            Thank you for your cooperation.
        </p>

    </div>
@endsection
