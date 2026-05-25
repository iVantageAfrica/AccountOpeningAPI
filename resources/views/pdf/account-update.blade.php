

<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Verdana',Arial,sans-serif;
            font-size: 12px;
            margin: 30px;
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
                Account Opening Form
            </div>
        </td>
    </tr>
</table>

<!-- ================= ACCOUNT META ================= -->
<table class="table no-border">
    <tr>
        <td><strong>Account Type:</strong>  {{ $accountData->account_type_name }}</td>
        <td><strong>Status:</strong> PENDING</td>
        <td><strong>Date:</strong> {{ $accountData->created_at?->format('Y-m-d') }}</td>
    </tr>
</table>

<!-- ================= USER CARD ================= -->
<table class="table">
    <tr class="section-title">
        <td colspan="4">Customer Information</td>
    </tr>

    <tr>
        <td width="25%">
            <strong>Firstname:</strong><br>{{ $userData->firstname }}
        </td>

        <td width="25%">
            <strong>Lastname:</strong><br>{{ $userData->lastname }}
        </td>

        <td width="25%">
            <strong>Middlename:</strong><br>{{ $userData->middle_name }}
        </td>

        <td width="25%" rowspan="3" class="center">
            <strong>Passport</strong><br><br>

            <img src="{{ $document->passport }}" alt="passport" class="passport">
        </td>
    </tr>

    <tr>
        <td><strong>Account Number:</strong><br>{{ $accountData->account_number }}</td>
        <td><strong>BVN:</strong><br>{{ $userData->bvn ?? '-' }}</td>
        <td><strong>NIN:</strong><br>{{ $userData->nin ?? '-' }}</td>
    </tr>

    <tr>
        <td><strong>Gender:</strong><br>{{ $userData->gender ?? '-' }}</td>
        <td><strong>Phone:</strong><br>{{ $userData->phone_number ?? '-' }}</td>
        <td><strong>Email:</strong><br>{{ $userData->email ?? '-' }}</td>
    </tr>
</table>

<!-- ================= PERSONAL INFO ================= -->
<table class="table">
    <tr class="section-title">
        <td colspan="2">Previous Personal Information</td>
    </tr>

    <tr><td><b>Mother Maiden Name</b></td><td>{{ $accountData->mother_maiden_name ?? '-' }}</td></tr>
    <tr><td><b>Marital Status</b></td><td>{{ $accountData->marital_status ?? '-' }}</td></tr>
    <tr><td><b>Employment Status</b></td><td>{{ $accountData->employment_status ?? '-' }}</td></tr>
    <tr><td><b>Employer</b></td><td>{{ $accountData->employer ?? '-' }}</td></tr>
    <tr><td><b>State</b></td><td>{{ $accountData->origin ?? '-' }}</td></tr>
    <tr><td><b>LGA</b></td><td>{{ $accountData->lga ?? '-' }}</td></tr>
    <tr><td><b>Address</b></td><td>{{ $accountData->address ?? '-' }}</td></tr>
</table>

<!-- ================= NEXT OF KIN ================= -->
<table class="table">
    <tr class="section-title">
        <td colspan="2">Previous Next of Kin Information</td>
    </tr>

    <tr><td><b>Name</b></td><td>{{ $accountData->next_of_kin_name ?? '-' }}</td></tr>
    <tr><td> <b>Relationship</b></td><td>{{ $accountData->next_of_kin_relationship ?? '-' }}</td></tr>
    <tr><td><b>Phone</b></td><td>{{ $accountData->next_of_kin_phone_number ?? '-' }}</td></tr>
    <tr><td><b>Address</b></td><td>{{ $accountData->next_of_kin_address ?? '-' }}</td></tr>
</table>
<table class="table">
    <tr class="section-title">
        <td colspan="2">Updated Personal Information</td>
    </tr>
    <tr><td><b>Mother Maiden Name</b></td><td>{{ $accountUpdateData->mother_maiden_name ?? '-' }}</td></tr>
    <tr><td><b>Email Address</b></td><td>{{ $accountUpdateData->email_address ?? '-' }}</td></tr>
    <tr><td><b>Phone Number</b></td><td>{{ $accountUpdateData->phone_number ?? '-' }}</td></tr>
    <tr><td><b>Marital Status</b></td><td>{{ $accountUpdateData->marital_status ?? '-' }}</td></tr>
    <tr><td><b>Employment Status</b></td><td>{{ $accountUpdateData->employment_status ?? '-' }}</td></tr>
    <tr><td><b>Employer</b></td><td>{{ $accountUpdateData->employer ?? '-' }}</td></tr>
    <tr><td><b>State</b></td><td>{{ $accountUpdateData->origin ?? '-' }}</td></tr>
    <tr><td><b>LGA</b></td><td>{{ $accountUpdateData->lga ?? '-' }}</td></tr>
    <tr><td><b>Address</b></td><td>{{ $accountUpdateData->address ?? '-' }}</td></tr>
    <tr><td><b>Account Officer</b></td><td>{{ $accountUpdateData->account_officer ?? '-' }}</td></tr>
</table>

<!-- ================= NEXT OF KIN ================= -->
<table class="table">
    <tr class="section-title">
        <td colspan="2">Updated Next of Kin Information</td>
    </tr>

    <tr><td><b>Name</b></td><td>{{ $accountUpdateData->next_of_kin_name ?? '-' }}</td></tr>
    <tr><td> <b>Relationship</b></td><td>{{ $accountUpdateData->next_of_kin_relationship ?? '-' }}</td></tr>
    <tr><td><b>Phone</b></td><td>{{ $accountUpdateData->next_of_kin_phone_number ?? '-' }}</td></tr>
    <tr><td><b>Address</b></td><td>{{ $accountUpdateData->next_of_kin_address ?? '-' }}</td></tr>
</table>


<!-- ================= FOOTER ================= -->
<table class="table no-border">
    <tr>
        <td style="font-size:10px;">
            Generated on {{ now()->format('Y-m-d H:i:s') }}
        </td>
    </tr>
</table>


</body>
</html>
