<?php

namespace App\Services\Account;

use App\Exceptions\CustomException;
use App\Helpers\FileUploadHelper;
use App\Jobs\AccountNotificationJob;
use App\Models\Account\Document;
use App\Models\Account\IndividualAccount;
use App\Models\Account\MerchantAccount;
use App\Models\Account\Referee;
use App\Models\User;
use App\Models\Utility\AccountType;
use App\Services\ThirdParty\ImperialMortgage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Throwable;

class AccountService
{
    public static function accountCreation(array $data, string $bvn): bool
    {
        $account = User::whereBvn($bvn)->first();
        if (!$account) {
            User::create([
                 'bvn' => $bvn,
                 'nin' => $data['NIN'] ?? null,
                 'firstname' => $data['first_name'] ?? null,
                 'lastname' => $data['surname'] ??  null,
                 'middle_name' => $data['middle_name'] ?? null,
                 'email' => $data['UserEmail'] ?? null,
                 'phone_number' => $data['UserPhoneNo'] ?? null,
                 'address' => $data['residential_address'] ?? null,
                 'gender' => $data['gender'] ?? null,
                 'date_of_birth' => $data['DateOfBirth'] ?? $data['DateOfBirt'] ?? null,
             ]);
        }
        return true;
    }

    /**
     * @throws Throwable
     */
    public static function createIndividualAccount(array $data): string
    {
        //Get user account data from user using the BVN and Check if user has such account
        $userData = User::whereBvn($data['bvn'])->firstOrFail()->toArray();
        ;
        self::ensureAccountDoesNotExist($userData['id'], $data['account_type_id']);

        //Create user individual account
        $accountType = AccountType::whereId($data['account_type_id'])->firstOrFail();
        $userData['account_type'] = $accountType->code;
        $accountNumber = ImperialMortgage::createIndividualAccount($userData);

        //Save Account Data
        DB::transaction(static function () use ($userData, $accountNumber, $data) {
            //Upload Documents
            $data['document_id'] = Document::create(self::processDocuments($data))->id;

            //Create user bank referee
            $data['referees'] = [];
            if ((int) $data['account_type_id'] === 1 && !empty($data['referee'])) {
                $data['referees'] = self::processReferees($data['referee']);
            }

            //Create Individual Account
            $data['account_number'] = $accountNumber;
            $data['user_id'] = $userData['id'];
            IndividualAccount::create($data);
        });

        AccountNotificationJob::dispatch($data['bvn'], $accountNumber, $accountType->name);
        return $accountNumber;
    }

    /**
     * @throws Throwable
     * @throws CustomException
     */
    public static function posMerchantAccount(array $data): string
    {
        //Get user account data from user using the BVN and Check if user has such account
        $userData = User::whereBvn($data['bvn'])->firstOrFail()->toArray();
        ;
        self::ensureAccountDoesNotExist($userData['id'], $data['account_type_id']);

        //Create user individual account
        $accountType = AccountType::whereId($data['account_type_id'])->firstOrFail();
        $userData['account_type'] = $accountType->code;
        $accountNumber = ImperialMortgage::createMerchantAccount($userData);

        //Save Account Data
        DB::transaction(static function () use ($userData, $accountNumber, $data) {
            //Upload Documents
            $data['document_id'] = Document::create(self::processDocuments($data))->id;
            $data['cac'] = isset($data['cac']) && $data['cac'] instanceof UploadedFile ? FileUploadHelper::uploadFile($data['cac']) : null;

            //Create Merchant Account
            $data['account_number'] = $accountNumber;
            $data['user_id'] = $userData['id'];
            MerchantAccount::create($data);
        });

        AccountNotificationJob::dispatch($data['bvn'], $accountNumber, $accountType->name);
        return $accountNumber;
    }


    /**
     * @throws CustomException
     */
    private static function ensureAccountDoesNotExist(int $userId, int $accountTypeId): void
    {
        if (IndividualAccount::whereUserId($userId)->whereAccountTypeId($accountTypeId)->exists()) {
            throw new CustomException('BVN already exist for such account', 409);
        }
    }

    private static function processReferees(array $referees): array
    {
        return collect($referees)->map(function ($referee) {
            return Referee::create([
                'name'          => $referee['name'],
                'email_address' => $referee['email_address'],
                'phone_number'  => $referee['phone_number'],
                'mobile_number' => $referee['mobile_number'],
            ])->id;
        })->toArray();
    }

    private static function processDocuments(array $data): array
    {
        return [
            'valid_id'     => FileUploadHelper::uploadFile($data['valid_id']),
            'signature'    => FileUploadHelper::uploadFile($data['signature']),
            'utility_bill' => FileUploadHelper::uploadFile($data['utility_bill']),
            'passport'     => FileUploadHelper::uploadFile($data['passport']),
        ];
    }

}
