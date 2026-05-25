
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Verdana',Arial,sans-serif;
            font-size: 12px;
            margin: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .header {
            background-color: #DE4F01;
            color: #fff;
        }

        .section-title {
            background-color: #DE4F01;
            color: #fff;
            font-weight: bold;
        }

        .no-border td {
            border: none;
        }

        .center {
            text-align: center;
        }

        .passport {
            width: 100px;
            height: 100px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

<!-- ================= HEADER ================= -->
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#DE4F01;">
    <tr>
        <td style="padding:15px 0 15px 40px;" width="60">
            <img src="https://www.imperialmortgagebank.com/assets/img/imperial_logo.png" width="45">
        </td>

        <td style="color:#ffffff; padding-top:1px;">
            <div style="font-size:16px; font-weight:bold;">
                Imperial Homes Mortgage Bank Limited
            </div>
            <div style="font-size:11px;">
                Account Referee Information
            </div>
        </td>
    </tr>
</table>

<!-- ================= ACCOUNT META ================= -->
<table class="table no-border">
    <tr>
        <td colspan="3" style="text-align: right;">
            <strong>Submitted On:</strong> 2026-05-09
        </td>
    </tr>
</table>

<!-- ================= USER CARD ================= -->
<table class="table">
    <tr class="section-title">
        <td colspan="3">Account Holder Information</td>
    </tr>


    <tr>
        <td><strong>Account Number:</strong><br>{{ $accountData->account_number }}</td>
        <td><strong>Account Name:</strong><br>@if(in_array($accountData->account_type_id, [1,2], true)) {{ $userData->firstname }} {{ $userData->lastname }}@else {{ $accountData->company_name }} @endif</td>
    </tr>

    <tr>
        <td><strong>Account Type:</strong><br> {{ $accountData->account_type_name }}</td>
        <td><strong>Created At:</strong><br> {{ $accountData->created_at?->format('Y-m-d') }}</td>
    </tr>


</table>
<table class="table">
    <tr class="section-title">
        <td colspan="3">Referee Information</td>
    </tr>

    <tr>
        <td width="30%"><strong>Full Name</strong></td>
        <td width="65%">{{ $refereeData->name }}</td>
    </tr>

    <tr>
        <td><strong>Phone</strong></td>
        <td>
            {{ $refereeData->phone_number ?? $refereeData->mobile_number ?? 'N/A' }}
        </td>
    </tr>

    <tr>
        <td><strong>Email</strong></td>

        <td>{{ $refereeData->email_address }}</td>
    </tr>

    <tr>
        <td><strong>Address</strong></td>

        <td>{{ $refereeData->address }}</td>
    </tr>

    <tr>
        <td><strong>Account Number</strong></td>

        <td>{{ $refereeData->account_number }}</td>
    </tr>

    <tr>
        <td><strong>Account Name</strong></td>

        <td>{{ $refereeData->account_name }}</td>
    </tr>

    <tr>
        <td><strong>Bank</strong></td>

        <td>{{ $refereeData->bank_name }}</td>
    </tr>

    <tr>
        <td><strong>Know Period</strong></td>

        <td>{{ $refereeData->known_period }}</td>
    </tr>

    <tr>
        <td><strong>Comment</strong></td>
        <td>{{ $refereeData->comment }}</td>
     </tr>

    <!-- Signature LAST -->
    <tr>
        <td colspan="3">
            <strong>Signature</strong><br><br>
            @if($refereeData && $refereeData->signature)

                @if(isImageFile($refereeData->signature))
                    <img src="{{ $refereeData->signature }}" width="80" alt="Signature">
                @else
                    <p>
                        📄 Document:
                        <a href="{{ $refereeData->signature }}">Click to download Signature</a>
                    </p>
                @endif
            @else
                <p>Signature not available</p>
            @endif
        </td>
    </tr>
</table>


</body>
</html>
