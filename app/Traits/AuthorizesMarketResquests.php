<?php

namespace App\Traits;

use App\Services\MarketAuthenticationService;

trait AuthorizesMarketResquests
{
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();

        $headers['Authorization'] = $accessToken;
    }

    public function resolveAccessToken()
    {
        $autheticationService = resolve(MarketAuthenticationService::class);

        if(auth()->user()) {
            return $autheticationService->getAuthenticatedUserToken();
        }

        return $autheticationService->getClientCredentialsToken();
    }
}