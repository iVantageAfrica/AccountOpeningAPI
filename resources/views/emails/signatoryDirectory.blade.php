@extends('emails.mailContainer')
@section('mailContent')
<div style="padding:0px 25px;">
                                <p style="line-height: 30px; font-size: 16px; margin: 0; padding: 25px 0px; ">
    Dear <b>{{ $name }} </b><br>You have been listed as a bank account {{ $type }} to  {{ $businessName }} as part of their account opening process with Imperial Homes Mortgage Bank
                                    Limited.
                                </p>
                                <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">To help
                                    us complete this process, we kindly request that you confirm your details by completing
                                     a short signatory form. Please click the link below to proceed:</p>
    <a href="{{ $url }}" style=" color:#DE4F01">{{ $url }}</a>
                                <br><br>
                                <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">
                                    As part of the confirmation, {!! $type === 'signatory'
    ? '<b>you will be required to upload a copy of your signature, passport photograph, proof of residential address, specimen card and mode of operation file</b>'
    : '<b>you will be required to upload a copy of your valid id, passport and signature</b>'
!!}  Kindly ensure you have a clear image or scanned copy of those documents
                                    ready before starting the form.
                                </p>
                                <p class="details" style="line-height: 30px; font-size: 16px; margin-top: 0px;">Your
                                    information will be treated with strict confidentiality and used solely for the
                                                                                                                purpose of account verification.<br>

                                    If you have any questions or require assistance, our support team will be happy to
                                    help.
                                    <br>
Thank you for your time and cooperation.
                                </p>
                            </div>
@endsection
