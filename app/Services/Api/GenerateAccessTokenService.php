<?php

namespace App\Services\Api;

use App\Enums\AccountConfigEnum;
use App\Models\Account;
use App\Traits\Models\AccountConfigTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateAccessTokenService
{
    use AccountConfigTrait;

    /** Generate the token for particular Account
     * @param int $accountConfigId
     */
    public function generateToken(int $accountConfigId) : string
    {
        $getAccountConfig = $this->getAccount($accountConfigId);

        if(!$getAccountConfig) throw new \Exception('Record not found', 404);

        return $this->apiRequest($getAccountConfig);
    }

    /** Api Request for Generate Access Token of Amazon Transparency Account
     * @param Account $accountConfig
     */
    public function apiRequest(Account $accountConfig) : string
    {
        $res = Http::asForm()->post('https://tpncy-web-services.auth.us-east-1.amazoncognito.com/oauth2/token', [
            "grant_type" => "client_credentials",
            "client_id" => $accountConfig->client_id,
            "client_secret" => $accountConfig->client_secret
        ]);

        $response = $res->json();
        Log::info('access token res', $response);

        if(isset($response['error']))
        {
            $accountConfig->update([
                'api_status' => AccountConfigEnum::getApiStatus(AccountConfigEnum::ERROR),
                'updated_at' => now()
            ]);

            throw new \Exception($response['error'], 500);
        }

        if(isset($response['access_token']))
        {
            $accountConfig->update([
                'access_token' => $response['access_token'],
                'api_status' => AccountConfigEnum::getApiStatus(AccountConfigEnum::WORKING),
                'updated_at' => now()
            ]);
            return $response['access_token'];
        }

        throw new \Exception('Something went wrong', 500);
    }
}
