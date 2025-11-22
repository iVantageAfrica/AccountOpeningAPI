<?php

namespace App\Services\ThirdParty;

use App\Exceptions\CustomException;
use Exception;
use Illuminate\Support\Facades\Http;

class BluSalt
{
    /**
     * @throws CustomException
     */
    public static function verifyBvn(string $bvnNumber): array
    {
        $baseUrl = config('services.bluSalt.baseUrl');
        $params = [
            'bvn_number' => $bvnNumber,
            'phone_number' => '01000000000',
        ];

        try {
            ini_set('max_execution_time', 300);
            $response = Http::withHeaders([
                'clientid' => config('services.bluSalt.clientId'),
                'apikey' => config('services.bluSalt.apiKey'),
                'appname' => config('services.bluSalt.appName'),
                'Content-Type' => 'application/json',
            ])->connectTimeout(30)
                ->timeout(180)
                ->post($baseUrl . '/v2/IdentityVerification/BVN', $params);

            $responseData = $response->json();
            return match ($responseData['status_code'] ?? 500) {
                200 => (static function () use ($responseData, $bvnNumber) {
                    $resultMap = [
                        'SeqRef' => $responseData['results']['request_reference'] ?? '',
                        'UserPhoneNo' => $responseData['results']['personal_info']['phone_number'] ?? $responseData['results']['personal_info']['phone_number_2'] ?? '',
                        'UserEmail' => $responseData['results']['personal_info']['email'] ?? '',
                        'BVN' => $bvnNumber,
                        'marital_status' => $responseData['results']['personal_info']['marital_status'] ?? '',
                        'gender' => $responseData['results']['personal_info']['gender'] ?? '',
                        'surname' => $responseData['results']['personal_info']['lastname'] ?? '',
                        'middle_name' => $responseData['results']['personal_info']['middle_name'] ?? '',
                        'first_name' => $responseData['results']['personal_info']['first_name'] ?? '',
                        'state_of_origin' => $responseData['results']['personal_info']['state_of_origin'] ?? '',
                        'lga_of_origin' => $responseData['results']['personal_info']['lga_of_origin'] ?? '',
                        'customer_id' => $responseData['results']['infoId'] ?? '',
                        'status' => $responseData['results']['level_of_account'] ?? '',
                        'NIN' => $responseData['results']['nin'] ?? '',
                        'UserVerifyRef' => $responseData['results']['bvn_number'] ?? '',
                        'systemdatetime' => date('Y-m-d H:i:s'),
                        'DateOfBirth' => $responseData['results']['personal_info']['date_of_birth'] ?? '',
                        'DateOfBirt' => $responseData['results']['personal_info']['date_of_birth'] ?? '',
                        'state_of_capture' => $responseData['results']['residential_info']['state_of_residence'] ?? '',
                        'residential_address' => $responseData['results']['residential_info']['residential_address'] ?? '',
                        'IgreeNIN' => $responseData['results']['nin'] ?? '',
                    ];
                    return [
                        'statusCode' => 200,
                        'message' => 'Successful',
                        'url' => '',
                        'data' => $resultMap,
                    ];
                })(),
                default => throw new CustomException($responseData ['description'] ?? 'Invalid BVN, Unable to retrieve details'),
            };
        } catch (Exception $ex) {
            throw new CustomException('Invalid BVN, Unable to retrieve details');
        }
    }
}
