<?php

namespace App\Services\Account;

use App\Exceptions\CustomException;
use App\Helpers\EncryptionHelper;
use App\Helpers\FileUploadHelper;
use App\Jobs\AccountNotificationJob;
use App\Jobs\AccountReferenceJob;
use App\Jobs\SignatoryDirectoryJob;
use App\Models\Account\CompanyDocument;
use App\Models\Account\CorporateAccount;
use App\Models\Account\DebitCardRequest;
use App\Models\Account\Directory;
use App\Models\Account\Document;
use App\Models\Account\IndividualAccount;
use App\Models\Account\Referee;
use App\Models\Account\Signatory;
use App\Models\User;
use App\Models\Utility\AccountType;
use App\Services\ThirdParty\ImperialMortgage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Random\RandomException;
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
        $userModel = User::whereBvn($data['bvn'])->firstOrFail();
        $userData = $userModel->toArray();
        self::ensureAccountDoesNotExist($userData['id'], $data['account_type_id'], 'INDIVIDUAL');

        //Create user individual account
        $accountType = AccountType::whereId($data['account_type_id'])->firstOrFail();
        $userData['account_type'] = $accountType->code;
        $accountNumber = ImperialMortgage::createIndividualAccount($userData);

        //Create and assigned user to mobile banking
        $internetBankingRegistration = self::internetBankingAssignment($userData);

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
            $data['address'] = $data['house_number'].', '.$data['street'].', '.$data['city'].', '.$data['state'];
            IndividualAccount::create($data);

            //Save user card request
            if ($data['debit_card']) {
                DebitCardRequest::create($data);
            }
        });

        $bankAccountReferenceUrl = self::generateAccountReferenceUrl($accountNumber, $data['account_type_id'], $userData['firstname'].' '.$userData['lastname']);
        AccountNotificationJob::dispatch(
            $data['bvn'],
            $accountNumber,
            $accountType->id,
            $accountType->name,
            $bankAccountReferenceUrl,
            $internetBankingRegistration['username'],
            $internetBankingRegistration['password'],
            $internetBankingRegistration['pin'],
            null,
            null
        );

        $userModel->update(['status' => true]);
        return $accountNumber;
    }


    /**
     * @throws Throwable
     * @throws CustomException
     */
    public static function corporateAccount(array $data): string
    {
        //Get user account data from user using the BVN and Check if user has such account
        $userModel = User::whereBvn($data['bvn'])->firstOrFail();
        $userData = $userModel->toArray();
        self::ensureAccountDoesNotExist($userData['id'], $data['account_type_id'], 'CORPORATE');

        //Create user corporate account
        $accountType = AccountType::whereId($data['account_type_id'])->firstOrFail();
        $data['account_type'] = $accountType->code;
        $accountNumber = ImperialMortgage::createCorporateAccount($data);
        $directorsId = [];
        $signatoryIds = [];

        //Save Account Data
        DB::transaction(static function () use (&$directorsId, &$signatoryIds, $userData, $accountNumber, $data) {
            //Save account directors and signatories
            $directorsId = array_map(static fn ($directory) => Directory::create($directory)->id, $data['director'] ?? []);
            $signatoryIds = array_map(static fn ($signatory) => Signatory::create($signatory)->id, $data['signatory'] ?? []);

            //Create corporate Account
            $data['signatories'] = $signatoryIds;
            $data['directors'] = $directorsId;
            $data['account_number'] = $accountNumber;
            $data['user_id'] = $userData['id'];
            CorporateAccount::create($data);

            //Save user card request
            if ($data['debit_card']) {
                DebitCardRequest::create($data);
            }
        });

        //Send User Notification
        $frontEndUrl = config('app.app_frontend_url');
        $companyDocumentUrl = $frontEndUrl.'/verification/company-document?' .
            http_build_query([
                'acc' => EncryptionHelper::secureTestString($accountNumber),
                'ty' => EncryptionHelper::secureTestString($data['company_type_id']),
                'bsNa' => EncryptionHelper::secureTestString($data['company_name']),
            ]);

        $username = null;
        $password = null;
        $pin = null;
        if ($accountType->id === 4) {
            //Create and assigned user to mobile banking
            $internetBankingRegistration = self::internetBankingAssignment($userData);
            $username = $internetBankingRegistration['username'];
            $password = $internetBankingRegistration['password'];
            $pin = $internetBankingRegistration['pin'];
        }
        AccountNotificationJob::dispatch(
            $data['bvn'],
            $accountNumber,
            $accountType->id,
            $accountType->name,
            $companyDocumentUrl,
            $username,
            $password,
            $pin,
            $data['company_name'],
            $data['business_email']
        );

        //Generate Signatory and Directory Verification Links and send mails
        self::dispatchSignatoryDirectoryJobs($data['director'] ?? [], $directorsId, $data['company_name'], 'directory', $data['company_type_id']);
        self::dispatchSignatoryDirectoryJobs($data['signatory'] ?? [], $signatoryIds, $data['company_name'], 'signatory', $data['company_type_id']);
        $userModel->update(['status' => true]);
        return $accountNumber;
    }

    public static function createBankAccountReference(array $data): bool
    {
        $accountData = IndividualAccount::whereAccountNumber($data['user_account_number'])->first()
            ?? CorporateAccount::whereAccountNumber($data['user_account_number'])->first();
        if (!$accountData) {
            return false;
        }
        $data['signature'] = isset($data['signature']) && $data['signature'] instanceof UploadedFile ? FileUploadHelper::uploadFile($data['signature']) : null;
        $refereeId = Referee::create($data)->id;
        $accountData->update([
            'referees' => array_merge($accountData->referees ?? [], [$refereeId]),
        ]);
        return true;
    }


    /**
     * @throws RandomException
     */
    public static function addBankAccountReference(array $data): bool
    {
        //Process the reference
        $refereeId = self::processReferees($data['referee']);
        match ($data['account_type_id']) {
            1 => IndividualAccount::whereAccountNumber($data['account_number'])->update(['referees' => $refereeId]),
            3 => CorporateAccount::whereAccountNumber($data['account_number'])->update(['referees' => $refereeId]),
            default => 'Invalid Account type Id'
        };

        //Pluck the emails out to send mail
        foreach ($data['referee'] as $index => $referee) {
            $mailData = [
                'name' => $referee['name'],
                'email' => $referee['email_address'],
                'account_name' => $data['account_name'],
                'account_type' => AccountType::whereId($data['account_type_id'])->first()->name,
                'account_type_id' => $data['account_type_id'],
                'url' => self::generateAccountReferenceSubmissionUrl($data['account_number'], $data['account_type_id'], $data['account_name'], $refereeId[$index]),
            ];
            AccountReferenceJob::dispatch($mailData);
        }
        return true;
    }

    /**
     * @throws CustomException
     */
    public static function updateBankAccountReference(array $data): bool
    {
        $refereeData = Referee::whereId($data['referee_id'])->first();
        if (!$refereeData) {
            throw new CustomException('Referee not found', 404);
        }
        if ($refereeData->is_submitted) {
            throw new CustomException('Referee is already submitted, Link is no longer accepted', 409);
        }
        return $refereeData->update([
            'account_name' => $data['account_name'],
            'account_type' => $data['account_type'],
            'account_number' => $data['account_number'],
            'bank_name' => $data['bank_name'],
            'known_period' => $data['known_period'] ?? null,
            'comment' => $data['comment'] ?? null,
            'is_submitted' => true,
            'submitted_at' => now(),
            'signature' => isset($data['signature']) && $data['signature'] instanceof UploadedFile
                ? FileUploadHelper::uploadFile($data['signature']) : null,
        ]);
    }

    /**
     * @throws RandomException
     * @throws CustomException
     */
    public static function updateCorporateAccountCompanyDocument(array $data): bool
    {
        $accountDetails = CorporateAccount::whereAccountNumber($data['account_number'])->first();
        if (!$accountDetails) {
            throw new CustomException('Account not found', 404);
        }
        if ($accountDetails->companyDocument && $accountDetails->companyDocument->is_submitted) {
            throw new CustomException('Company Document is already submitted', 409);
        }
        $data['account_type_id'] = $accountDetails->account_type_id;
        $data['account_name'] = $accountDetails->company_name;

        //Upload Company Document
        $documentPayload = [];
        foreach ((new CompanyDocument())->getFillable() as $field) {
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                $documentPayload[$field] = FileUploadHelper::uploadFile($data[$field]);
            }
        }
        $documentPayload['is_submitted'] = true;
        $documentPayload['submitted_at'] = now();
        $companyDocument = CompanyDocument::create($documentPayload);
        $accountDetails->company_document_id = $companyDocument->id;
        $accountDetails->save();
        //Process referee
        self::addBankAccountReference($data);
        return true;
    }

    /**
     * @throws CustomException
     */
    public static function updateDirectorySignatory(array $data): bool
    {
        $modelClass = $data['type'] === 'directory' ? Directory::class : Signatory::class;
        $model = $modelClass::find($data['directorySignatoryId']);
        if (!$model) {
            throw new CustomException('Record not found.', 404);
        }

        if ($model->is_submitted) {
            throw new CustomException('This record has already been submitted. Link is no longer accepted.', 409);
        }
        $documentPayload = [];
        foreach ($model->getFillable() as $field) {
            if (in_array($field, ['is_submitted', 'submitted_at'])) {
                continue;
            }
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                $documentPayload[$field] = FileUploadHelper::uploadFile($data[$field]);
            }
        }
        $documentPayload['is_submitted'] = true;
        $documentPayload['submitted_at'] = now();
        $model->update($documentPayload);
        return true;
    }


    /**
     * @throws CustomException
     */
    public static function ensureAccountDoesNotExist(int $userId, int $accountTypeId, string $type): void
    {
        $query = match (strtoupper($type)) {
            'INDIVIDUAL' => IndividualAccount::whereUserId($userId)->whereAccountTypeId($accountTypeId),
            'MERCHANT', 'CORPORATE' => CorporateAccount::whereUserId($userId)->whereAccountTypeId($accountTypeId),
            default => null
        };

        if (!$query) {
            throw new CustomException('Invalid account type', 400);
        }
        if ($query->exists()) {
            throw new CustomException('BVN already exists for this account Type, Kindly visit our online Banking channel for more details', 409);
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
            'name' => $data['name'] ?? '',
        ];
    }

    /**
     * @throws RandomException
     */
    private static function generateAccountReferenceUrl(string $accountNumber, int $accountTypeId, string $accountName): string|null
    {
        if ($accountTypeId === 2) {
            return null;
        }
        $params = [
            'acc'   => EncryptionHelper::secureTestString($accountNumber),
            'ty'    => EncryptionHelper::secureTestString($accountTypeId),
            'acNa'  => EncryptionHelper::secureTestString($accountName),
        ];
        $frontEndUrl = config('app.app_frontend_url');
        return $frontEndUrl.'/verification/account-reference?' . http_build_query($params);
    }

    /**
     * @throws RandomException
     */
    private static function generateAccountReferenceSubmissionUrl(string $accountNumber, int $accountTypeId, string $accountName, $refereeId): string
    {
        $params = [
            'acc'   => EncryptionHelper::secureTestString($accountNumber),
            'ty'    => EncryptionHelper::secureTestString($accountTypeId),
            'acNa'  => EncryptionHelper::secureTestString($accountName),
            'refId' => EncryptionHelper::secureTestString($refereeId),
        ];
        $frontEndUrl = config('app.app_frontend_url');
        return $frontEndUrl.'/verification/reference-submission?' . http_build_query($params);
    }

    /**
     * @throws RandomException
     */
    private static function dispatchSignatoryDirectoryJobs(array $items, array $ids, string $companyName, string $type, string $companyTypeId): void
    {
        foreach ($items as $i => $item) {
            $fullName = trim(($item['firstname'] ?? '') . ' ' . ($item['lastname'] ?? '')) ?: ($item['name'] ?? 'Unknown');
            $mailData = [
                'name' => $fullName,
                'emailAddress' => $item['email_address'] ?? '',
                'businessName' => $companyName,
                'type' => $type,
                'url' => self::generateAccountSignatoryDirectoryUrl($ids[$i], $fullName, $companyName, $type, $companyTypeId),
            ];
            SignatoryDirectoryJob::dispatch($mailData);
        }
    }

    /**
     * @throws RandomException
     */
    private static function generateAccountSignatoryDirectoryUrl(int $id, string $name, string $businessName, string $type, string $companyTypeId): ?string
    {
        $frontEndUrl = config('app.app_frontend_url');
        $params = [
            'id'    => EncryptionHelper::secureTestString($id),
            'na'    => EncryptionHelper::secureTestString($name),
            'buNa'  => EncryptionHelper::secureTestString($businessName),
            'cmTy' => EncryptionHelper::secureTestString($companyTypeId),
        ];
        $baseUrl = $type === 'signatory'
            ? $frontEndUrl.'/verification/signatory-verification?'
            : $frontEndUrl.'/verification/directory-verification?';
        return $baseUrl . http_build_query($params);
    }

    private static function internetBankingAssignment(array $userData): array
    {
        //Create and assigned user to mobile banking
        $username = !empty($userData['email']) ? $userData['email'] : strtolower($userData['firstname'] . '.' . $userData['lastname']);
        $password = ucfirst(generateRandomAlphanumeric(6).'@'.generateRandomNumber(3));
        $pin = generateRandomNumber(4);
        $userData['password'] = $password;
        $userData['pin'] = $pin;
        $userData['username'] = $username;
        $internetBankingReg = ImperialMortgage::internetBankingRegistration($userData);

        return ['username' => $internetBankingReg ? $username : '',
                'pin' => $internetBankingReg ? $pin : '',
                'password' => $internetBankingReg ? $password : '',
            ];
    }
}
