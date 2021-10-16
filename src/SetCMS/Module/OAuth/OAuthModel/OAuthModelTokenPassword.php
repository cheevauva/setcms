<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\OAuth\OAuthToken;

class OAuthModelTokenPassword extends OAuthModel
{

    public string $client_id = '';
    public string $username = '';
    public string $password = '';
    private ?OAuthToken $oauthToken = null;

    protected function validate(): void
    {
        if (empty($this->client_id)) {
            $this->addMessageAsValidation('client_id is required', 'invalid_request');
        }

        if (empty($this->password)) {
            $this->addMessageAsValidation('password is required', 'invalid_request');
        }

        if (empty($this->username)) {
            $this->addMessageAsValidation('username is required', 'invalid_request');
        }
    }

    public function entity(?OAuthToken $oauthToken = null): ?OAuthToken
    {
        if ($oauthToken instanceof OAuthToken) {
            $this->oauthToken = $oauthToken;
        }
        
        return $this->oauthToken;
    }
    
    public function toArray(): array
    {
        $array = parent::toArray();
        
        if (!empty($array)) {
            return $array;
        }
        
        $oauthToken = $this->oauthToken;
        
        return [
            'access_token' => $oauthToken->token,
            'refresh_token' => $oauthToken->tokenRefresh,
            'expires_in' => $oauthToken->dateExpiried->getTimestamp() - (new \DateTime)->getTimestamp(),
            'token_type' => 'bearer',
        ];
    }

}
