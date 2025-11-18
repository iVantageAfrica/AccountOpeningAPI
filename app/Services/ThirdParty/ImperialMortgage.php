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
                ->post($baseurl.'/bvnval/OPsVerifyInfo', $params);

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
        $apiKey = config('services.accountOpening.apiKey');
        $residential_address = $data['house_number'].', '.$data['street'].', '.$data['city'].', '.$data['state'];
        $params = [
            'FirstName' => $data['firstname'],
            'LastName' => $data['lastname'],
            'BVN' => $data['bvn'],
            'DOB' => $data['date_of_birth'],
            'Address' => $residential_address,
            'AccountType' => $data['account_type'],
            'Gender' => $data['gender'],
            'PhoneNumber' => $data['phone_number'],
            'Email' => $data['email'],
        ];

        try {
            ini_set('max_execution_time', 240);
            $response = Http::withHeaders([
                'apikey' => $apiKey,
                'Content-Type' => 'application/json',
            ])->connectTimeout(30)
                ->timeout(180)
                ->post($baseurl.'/CreateAccount', $params);

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
            throw new CustomException('An error occurred while creating account: '.$e->getMessage());
        }
    }

    public static function createMerchantAccount(array $data): string
    {
        return '9199999999';
    }
}
