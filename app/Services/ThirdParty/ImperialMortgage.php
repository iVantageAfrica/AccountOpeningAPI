<?php

namespace App\Services\ThirdParty;

use App\Exceptions\CustomException;
use Exception;
use Illuminate\Support\Facades\Http;

class ImperialMortgage
{
    /**
     * @throws CustomException
     */
    public static function verifyBvn(string $bvnNumber): array
    {
        $baseurl = config('services.imperialMortgageBvn.baseUrl');
        $authToken = config('services.imperialMortgageBvn.authToken');
        $params = [
            'UserVerifyRef' => $bvnNumber,
            'UserVerifyType' => '0',
            'deviceinfo' => 'iphoneproMax',
        ];
        try {
            ini_set('max_execution_time', 240);
            $response = Http::withHeaders([
                'AuthToken' => $authToken,
                'Content-Type' => 'application/json',
            ])->connectTimeout(30)
                ->timeout(180)
                ->post($baseurl.'/bvnval/OPsVerifyInfo', $params)->json();

            return match ($response['responseCode'] ?? null) {
                '01' => [
                    'statusCode' => 200,
                    'message' => $response['responseText'],
                    'url' => '',
                    'data' => $response['data'][0],
                ],
                '00' => [
                    'statusCode' => 201,
                    'message' => 'BVN verification pending, Kindly verify using the link provided',
                    'url' => $response['url'],
                    'data' => null,
                ],
                default =>  throw new CustomException('BVN verification failed: ' . ($response['responseMessage'] ?? 'Unknown error'))
            };
        } catch (Exception $e) {
            throw new CustomException('An error occurred while verifying BVN: '.$e->getMessage());
        }
    }

    /**
     * @throws CustomException
     */
    public static function createIndividualAccount(array $data): string
    {
        return '0137712594';
        $baseurl = config('services.accountOpening.baseUrl');
        $residential_address = $data['house_number'].', '.$data['street'].', '.$data['city'].', '.$data['state'];
        $params = [
            'FirstName' => $data['firstname'],
            'LastName' => $data['lastname'],
            'BVN' => $data['bvn'],
            'DOB' => $data['date_of_birth'],
            'Address' => $residential_address,
            'AccountType' => $data['account_type'],
            'Gender' => $data['gender'],
            'PhoneNumber' => '0'.substr($data['phone_number'], -10),
            'Email' => $data['email'],
        ];

        return self::accountOpening($baseurl.'/CreateAccount', $params);
    }

    public static function createMerchantAccount(array $data): string
    {
        return '9199999999';
    }

    /**
     * @throws CustomException
     */
    public static function createCorporateAccount(array $data): string
    {
        $baseurl = config('services.accountOpening.baseUrl');
        $params = [
            'CoyName' => $data['company_name'],
            'tin' =>  $data['tin'],
            'OfficeAddress' => $data['address'],
            'AccountType' => $data['account_type'],
            'OfficePhoneNumber' => '0'. substr($data['phone_number'], -10),
            'OfficeEmail' => $data['business_email'],
            'Director1SurName' => $data['director'][0]['lastname'],
            'Director1FirstName' => $data['director'][0]['firstname'],
            'Director1Bvn' => $data['director'][0]['bvn'],
            'Director2SurName' => $data['director'][1]['lastname'] ?? '',
            'Director2FirstName' => $data['director'][1]['firstname'] ?? '',
            'Director2Bvn' => $data['director'][1]['bvn'] ?? '',
        ];
        return '0484849494';
        return self::accountOpening($baseurl.'/CreateCorporateAccount', $params);
    }

    /**
     * @param mixed $baseurl
     * @param array $params
     * @return mixed|string
     * @throws CustomException
     */
    private static function accountOpening(mixed $baseurl, array $params): mixed
    {
        $apiKey = config('services.accountOpening.apiKey');
        try {
            ini_set('max_execution_time', 240);
            $response = Http::withHeaders([
                'apikey' => $apiKey,
                'Content-Type' => 'application/json',
            ])->connectTimeout(30)
                ->timeout(180)
                ->post($baseurl, $params);

            $responseData = $response->json();
            if (($responseData['status'] ?? null) !== 'success') {
                throw new CustomException('Account cannot be create at the moment, Try again later.');
            }
            $accountNumber = $responseData['data']['accountNo'] ?? '';
            if (!$accountNumber) {
                throw new CustomException('Account creation is unavailable, Kindly try again.');
            }
            return $accountNumber;
        } catch (Exception $e) {
            throw new CustomException('An error occurred while creating account: ' . $e->getMessage());
        }
    }
}
