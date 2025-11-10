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
            $response = Http::withHeaders([
                'AuthToken' => $authToken,
                'Content-Type' => 'application/json',
            ])->post($baseurl.'/bvnval/OPsVerifyInfo', $params);

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
}
