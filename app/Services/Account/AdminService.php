<?php

namespace App\Services\Account;

use App\Exceptions\CustomException;
use App\Helpers\FileUploadHelper;
use App\Models\Account\CorporateAccount;
use App\Models\Account\DebitCardRequest;
use App\Models\Account\Directory;
use App\Models\Account\Document;
use App\Models\Account\IndividualAccount;
use App\Models\Account\Referee;
use App\Models\Account\Signatory;
use App\Models\Admin;
use App\Models\User;
use App\Services\Utility\JWTTokenService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use JsonException;
use Random\RandomException;

class AdminService
{
    /**
     * @throws CustomException
     * @throws RandomException
     */
    public static function authenticate(array $data): array
    {
        $admin = Admin::whereEmail($data['email'])->first();
        if (!$admin) {
            throw new CustomException('Invalid email address or password', 401);
        }
        if (!Hash::check($data['password'], $admin->password)) {
            throw  new CustomException('Invalid email address or password', 401);
        }
        return [
            'token' => JWTTokenService::generateToken($admin->adminInformation()),
            'adminInformation' => $admin->adminInformation(),
        ];
    }

    public static function customerList(): Builder
    {
        return User::whereStatus(true)
            ->with(['savingsAccount', 'currentAccount'])
            ->orderByDesc('id');
    }

    public static function customerSummary(): array
    {
        $query = User::whereStatus(true);
        return [
            'totalCustomers'   => (clone $query)->count(),
            'weeklyCustomers'  => (clone $query)->thisWeek()->count(),
            'monthlyCustomers' => (clone $query)->thisMonth()->count(),
            'lastMonth'        => (clone $query)->lastMonth()->count(),
        ];
    }

    public static function individualAccount(string|int $accountTypeId): Builder
    {
        return IndividualAccount::whereAccountTypeId($accountTypeId)
            ->with('user')
            ->orderByDesc('id');
    }

    public static function corporateAccountList(): Builder
    {
        return CorporateAccount::with(['user', 'companyType'])
            ->orderByDesc('id');
    }

    public static function individualAccountSummary(string|int $accountTypeId): array
    {
        $summary = IndividualAccount::where('account_type_id', $accountTypeId)
            ->selectRaw('
            COUNT(*) AS "totalAccount",
            COUNT(CASE WHEN LOWER(status) = \'pending\' THEN 1 END) AS "pendingAccount",
            COUNT(CASE WHEN LOWER(status) = \'approved\' THEN 1 END) AS "approvedAccount",
            COUNT(CASE WHEN LOWER(status) LIKE \'awt%\' THEN 1 END) AS "awaitingAccount"
        ')->first();

        return $summary?->toArray() ?? [
            'totalAccount' => 0,
            'pendingAccount' => 0,
            'approvedAccount' => 0,
            'awaitingAccount' => 0,
        ];
    }

    public static function corporateAccountSummary(): array
    {
        $summary = CorporateAccount::selectRaw('
            COUNT(*) AS "totalAccount",
            COUNT(CASE WHEN LOWER(status) = \'pending\' THEN 1 END) AS "pendingAccount",
            COUNT(CASE WHEN LOWER(status) = \'approved\' THEN 1 END) AS "approvedAccount",
            COUNT(CASE WHEN LOWER(status) LIKE \'awt%\' THEN 1 END) AS "awaitingAccount"
        ')->first();

        return $summary?->toArray() ?? [
            'totalAccount' => 0,
            'pendingAccount' => 0,
            'approvedAccount' => 0,
            'awaitingAccount' => 0,
        ];
    }

    /**
     * @throws CustomException
     */
    public static function fetchIndividualAccount(string|int $accountNumber): Builder|IndividualAccount|null
    {
        $accountDetails = IndividualAccount::whereAccountNumber($accountNumber)
            ->with(['user', 'document'])
            ->first();

        if (!$accountDetails) {
            throw new CustomException('Invalid account number', 404);
        }
        $refereeIds = $accountDetails->referees ?? [];
        $accountDetails->setRelation('referees', Referee::whereIn('id', $refereeIds)->get());
        return $accountDetails;
    }


    /**
     * @throws CustomException
     */
    public static function fetchCorporateAccount(string|int $accountNumber): Builder|CorporateAccount|null
    {
        $accountDetails = CorporateAccount::whereAccountNumber($accountNumber)
            ->with(['user', 'companyType', 'companyDocument'])
            ->first();

        if (!$accountDetails) {
            throw new CustomException('Invalid account number', 404);
        }
        $refereeIds = $accountDetails->referees ?? [];
        $signatoryIds = $accountDetails->signatories ?? [];
        $directorIds = $accountDetails->signatories ?? [];
        $accountDetails->setRelation('referees', Referee::whereIn('id', $refereeIds)->get());
        $accountDetails->setRelation('signatories', Signatory::whereIn('id', $signatoryIds)->get());
        $accountDetails->setRelation('directories', Directory::whereIn('id', $directorIds)->get());
        return $accountDetails;
    }

    public static function listCardsRequest(): Collection
    {
        return DebitCardRequest::with(['user', 'accountType'])
            ->orderByDesc('id')
            ->get();
    }

    /**
     * @throws JsonException
     */
    public static function dataLink(): void
    {
        $path = storage_path('app/database_export.json');
        $jsonContent = file_get_contents($path);
        $data = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        $corporates = $data['corporate_accounts'];

        //Create admin account
        $admins = $data['users'];
        foreach ($admins as $admin) {
            Admin::create([
                'firstname' => $admin['firstname'],
                'lastname' => $admin['lastname'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password']),
                'is_admin' => $admin['admin'],
            ]);
        }

        //        //Create Individual Account
        //        $individualAccount = $data['individual_accounts'];
        //        foreach ($individualAccount as $individual) {
        //            if (empty($individual['bvn'])) {
        //                continue;
        //            }
        //
        //            //Create user account, but check if bvn exist before creating
        //            $user = User::whereBvn($individual['bvn'])->first();
        //            if (!$user) {
        //                $user = User::create([
        //                    'bvn' =>  $individual['bvn'],
        //                    'nin' => $individual['NIN'] ?? null,
        //                    'firstname' => $individual['firstname'] ?? null,
        //                    'lastname' => $individual['lastname'] ??  null,
        //                    'middle_name' => $individual['middlename'] ?? null,
        //                    'email' => $individual['email'] ?? null,
        //                    'phone_number' => $individual['phoneno'] ?? null,
        //                    'address' => $individual['address'] ?? null,
        //                    'gender' => $individual['gender'] ?? null,
        //                    'date_of_birth' => $individual['dateofbirth'] ?? $data['DateOfBirt'] ?? null,
        //                ]);
        //            }
        //            $userId = $user->id;
        //
        //            //check if its savings account or current account and upload referee
        //            $accountTypeId = $individual['accounttype']  === '101' ? '1' : '2';
        //            if ($accountTypeId === '1') {
        //                //Create user bank referee
        //                $refereeId = self::processRefereesFromIndividual($individual);
        //            }
        //
        //            //Create document to get id
        //            $docFields = [
        //                'valid_id'   => FileUploadHelper::buildDocumentPath($individual['identification'] ?? null),
        //                'signature'  => FileUploadHelper::buildDocumentPath($individual['signaturemandate'] ?? null),
        //                'utility_bill' => FileUploadHelper::buildDocumentPath($individual['utilitybill'] ?? null),
        //                'passport'   => FileUploadHelper::buildDocumentPath($individual['image'] ?? null),
        //            ];
        //            $hasDocument = collect($docFields)->filter()->isNotEmpty();
        //            $documentId = $hasDocument ? Document::create($docFields)->id : null;
        //
        //            //Create Individual account
        //            IndividualAccount::create([
        //                'user_id' => $userId,                                               'account_type_id' => $accountTypeId,
        //                'account_number' => $individual['accountno'] ?? null,               'mother_maiden_name' => $individual['mothermaidenname'] ?? null,
        //                'phone_number' => $individual['phoneno2'] ?? null,                  'employment_status' => $individual['employmentstatus'] ?? null,
        //                'employer_address' => $individual['employeraddress'] ?? null,       'employer' => $individual['employername'] ?? null,
        //                'title' => $individual['title'] ?? null,                            'status' => $individual['status'] ?? null,
        //                'referrer' => $individual['referrer'] ?? null,                      'occupation' => $individual['occupation'] ?? null,
        //                'marital_status' => $individual['maritalstatus'] ?? null,           'address' => $individual['address'],
        //                'next_of_kin_name' => $individual['nextofkinname'] ?? null,         'next_of_kin_address' => $individual['nextofkinaddress'] ?? null,
        //                'next_of_kin_relationship' => $individual['nextofkinrelationship'] ?? null,  'next_of_kin_phone_number' => $individual['nextofkinphone'] ?? null,
        //                'document_id' => $documentId,                                        'referees' => $refereeId ?? null,
        //                'debit_card' => false,
        //            ]);
        //
        //        }
    }

    private static function processRefereesFromIndividual(array $individual): array
    {
        $referees = [];
        foreach ([1, 2] as $index) {
            $ref = [
                'name'          => $individual["referee{$index}name"] ?? null,
                'email_address' => $individual["referee{$index}email"] ?? null,
                'phone_number'  => $individual["referee{$index}phoneno"] ?? null,
                'mobile_number' => $individual["referee{$index}phoneno"] ?? null,
            ];
            if (!array_filter($ref)) {
                continue;
            }
            $referees[] = Referee::create($ref)->id;
        }

        return $referees;
    }
}
