@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding: 0px 25px;">

        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px;">
            Dear <b>Support Team,</b><br />
            A new customer account has been successfully created on the Customer Self-Service
            Portal. Please find the account details below for your review and records.
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



        <!-- What Is Required -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 20px 0 10px;">
            What Is Required from You
        </p>
        <p style="line-height: 30px; font-size: 16px; margin: 0 0 16px;">
            Kindly review the new account registration and complete the necessary onboarding
            verification on the Core Banking Application (CBA). Click the link below to access
            the customer's profile:
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
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">A PDF summary of
                the customer's registration is attached to this email</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">Identity and
                supporting documents submitted by the customer (if applicable) are attached</li>
            <li style="font-size: 14px; line-height: 28px; margin-bottom: 4px;">The account can
                also be viewed from the customer management dashboard</li>
        </ul>

        <!-- Important Information -->
        <p
            style="font-size: 13px; font-weight: 500; color: #8d91a0; text-transform: uppercase; letter-spacing: 0.06em; margin: 20px 0 10px;">
            Important Information
        </p>
        <ul
            style="margin: 0 0 24px; padding: 14px 14px 14px 34px; border: 1px solid #e5e5e5; border-radius: 8px;">
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">
                This account was created directly by the customer through the approved
                self-service platform</li>
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">
                All registration information has been logged for audit purposes</li>
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">
                Appropriate KYC verification should be completed before activating the account
                on the Core Banking Application (CBA)</li>
            <li style="font-size: 14px; line-height: 28px; color: #8d91a0; margin-bottom: 4px;">
                The customer will not have full account access until the verification process is
                completed</li>
        </ul>

        <p style="line-height: 30px; font-size: 16px; margin: 0 0 25px;">
            Thank you for your cooperation.
        </p>

    </div>
@endsection
