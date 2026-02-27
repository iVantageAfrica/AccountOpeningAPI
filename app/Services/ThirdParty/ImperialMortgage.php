<?php

namespace App\Services\ThirdParty;

use App\Exceptions\CustomException;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
use Throwable;

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
        return generateRandomNumber(11);
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
        return generateRandomNumber(11);
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
        return generateRandomNumber(11);
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
                Log::info('Imperial Account Opening fail: '. $responseData);
                throw new CustomException('Account cannot be create at the moment, Try again later.');
            }
            $accountNumber = $responseData['data']['accountNo'] ?? '';
            if (!$accountNumber) {
                Log::info('Imperial Account Opening fail: '. $responseData);
                throw new CustomException('Account creation is unavailable, Kindly try again.');
            }
            return $accountNumber;
        } catch (Exception $e) {
            throw new CustomException('An error occurred while creating account: ' . $e->getMessage());
        }
    }


    public static function internetBankingRegistration(array $data): bool
    {
        return true;
        $payload = [
            'username'      => $data['username'],
            'firstname'     => $data['firstname'],
            'surname'       => $data['lastname'],
            'middlename'    => $data['middle_name'] ?? null,
            'email'         => $data['email'],
            'phone'         => $data['phone_number'],
            'password'      => $data['password'],
            'pin'           => $data['pin'],
            'referralCode'  => 'REF2026',
        ];

        Log::info('Payload', $payload);

        try {
            $response = Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://api-gateway.imperialmortgagebank.com/mobile/client/register', $payload);

            if (!$response->successful()) {
                Log::error('Imperial Mobile Registration HTTP failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return false;
            }

            $responseData = $response->json();
            if (($responseData['success'] ?? false) !== true) {
                Log::warning('Imperial Mobile Registration API failed', ['response' => $responseData,]);
                return false;
            }
            return true;

        } catch (Throwable $e) {
            Log::error('Imperial Mobile Registration Exception', ['error' => $e->getMessage(),]);
            return false;
        }
    }

    public static function sendSmsToUser(string $phoneNumber, string $message): bool
    {
        $phoneNumber = '234' . substr(preg_replace('/\D/', '', $phoneNumber), -10);

        $textHex = bin2hex($message);
        $configUsername = config('services.vanso.username');
        $configPassword = config('services.vanso.password');
        $url = config('services.vanso.url');


        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<operation type="submit">
    <account username="{$configUsername}" password="{$configPassword}" />
    <submitRequest>
        <deliveryReport>true</deliveryReport>
        <sourceAddress type="alphanumeric">ImperialMBL</sourceAddress>
        <destinationAddress type="international">{$phoneNumber}</destinationAddress>
        <text encoding="ISO-8859-1">{$textHex}</text>
    </submitRequest>
</operation>
XML;

        try {
            $response = Http::withHeaders(['Content-Type' => 'text/xml'])
                ->withBody($xml, 'text/xml')
                ->post($url)
                ->body();
            $xmlResponse = new SimpleXMLElement($response);
            $submitResponse = $xmlResponse->submitResponse[0] ?? null;
            return isset($submitResponse->error['code']) && (string)$submitResponse?->error['code'] === '0';
        } catch (Throwable $e) {
            return false;
        }
    }
}
