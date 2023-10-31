<?php

namespace App\Services;
use App\Traits\ConsumesExternalServices;
use App\Traits\InteractsWithMarketResponses;
use App\Traits\AuthorizesMarketResquests;

class MarketAuthenticationService
{
    
    protected $authUri;
    protected $baseUri;
    protected $clientId;
    protected $clientSecret;

    /**
     * The client_id to identify the password client in the API
     * @var string
     */
    protected $passwordClientId;

    /**
     * The client_secret to identify the password client in the API
     * @var string
     */
    protected $passwordClientSecret;
    
    use ConsumesExternalServices, InteractsWithMarketResponses;

    public function __construct()
    {
        $this->authUri = config('services.meli.auth_uri');
        $this->baseUri = config('services.meli.base_uri');
        $this->clientId = config('services.meli.client_id');
        $this->clientSecret = config('services.meli.client_secret');
        $this->passwordClientId = config('services.meli.password_client_id');
        $this->passwordClientSecret = config('services.meli.password_client_secret');
    }

    public function getClientCredentialsToken()
    {
        if($token = $this->existingValidClientCredentialsToken()) {
            return $token;
        }

        $formParams = [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'client_credentials');

        return "{$tokenData->token_type} {$tokenData->access_token}";
    }

    public function resolveAuthorizationUrl()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => route('authorization'),
            //'scope' => 'purchase-product manage-products manage-account read-general',
        ]);

        return "{$this->authUri}authorization?{$query}";
    }


    public function getCodeToken($code)
    {
        $formParams = [
            'grant_type' => 'authorization_code',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => route('authorization'),
            'code' => $code,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'authorization_code');

        return $tokenData;
    }

    public function getPasswordToken($username, $password)
    {
        $formParams = [
            'grant_type' => 'password',
            'client_id' => $this->passwordClientId,
            'client_secret' => $this->passwordClientSecret,
            'username' => $username,
            'password' => $password,
            'scope' => 'purchase-product manage-products manage-account read-general',
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, 'password');

        return $tokenData;
    }

    public function getAuthenticatedUserToken()
    {
        $user = auth()->user();

        if(now()->lt($user->token_expires_at)){
            return $user->access_token;
        }

        return $this->refreshAuthenticatedUserToken($user);

    }

    public function refreshAuthenticatedUserToken($user)
    {
        $clientId = $this->clientId;
        $clientSecret = $this->clientSecret;

        if($user->grant_type === 'password') {
            $clientId = $this->passwordClientId;
            $clientSecret = $this->passwordClientSecret;
        }

        $formParams = [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $user->refresh_token,
        ];

        $tokenData = $this->makeRequest('POST', 'oauth/token', [], $formParams);

        $this->storeValidToken($tokenData, $user->grant_type);

        $user->fill([
            'access_token' => $tokenData->access_token,
            'refresh_token' => $tokenData->refresh_token,
            'token_expires_at' => $tokenData->token_expires_at,
        ]);

        $user->save();

        return $user->access_token;
    }


    public function storeValidToken($tokenData, $grantType)
    {
        $tokenData->token_expires_at = now()->addSeconds($tokenData->expires_in - 5);

        $tokenData->access_token = "{$tokenData->token_type} {$tokenData->access_token}";

        $tokenData->grant_type = $grantType;

        session()->put(['current_token' => $tokenData ]);
    }

    public function existingValidClientCredentialsToken()
    {
        if(session()->has('current_token')){
            $tokenData = session()->get('current_token');

            if(now()->lt($tokenData->token_expires_at)){
                
                return $tokenData->access_token;
            }
        }
    }


}