@extends('emails.mailContainer')
@section('mailContent')
    <div style="padding:0px 25px;">
        @if($notificationType === \App\Enum\SupportNotificationEnum::ACCOUNT_CREATION->value)
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
            Dear <b>Support, </b><br> This is to notify you that a new account has been created on Imperial Homes Account Opening website
            <br />
           Attached to this email is the account information and necessary document uploaded during account creation.
        </p>
        @elseif($notificationType === \App\Enum\SupportNotificationEnum::REFEREE_UPDATE->value)
        <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
            Dear <b>Support, </b><br> This is to notify you that a referee to an account has been updated.
            <br />
            Attached to this email is the account information, referee information and necessary document uploaded during the process.
        </p>
        @elseif($notificationType === \App\Enum\SupportNotificationEnum::ACCOUNT_UPDATE->value)
                <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px 15px 0px">
                    Dear <b>Support, </b><br> This is to notify you that information for an account has been updated.
                    <br />
                    Attached to this email is the updated account information and the previous account information.
                </p>
            @endif
        <p style="line-height: 30px; font-size: 16px; margin: 0;">Thank you for your
            cooperation and support.
        </p>
    </div>
@endsection
