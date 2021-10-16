<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\OAuth\OAuthToken;

class OAuthModelTokenRefreshToken extends OAuthModel
{

    public string $client_id = '';
    public string $refresh_token = '';
    private ?OAuthToken $oauthToken = null;

    protected function validate(): void
    {
        if (empty($this->client_id)) {
            $this->addMessageAsValidation('client_id is required', 'invalid_request');
        }

        if (empty($this->refresh_token)) {
            $this->addMessageAsValidation('refresh_token is required', 'invalid_request');
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
            'expires_in' => $oauthToken->dateExpiried->getTimestamp() - (new \DateTime)->getTimestamp(),
            'token_type' => 'bearer',
        ];
    }

}
