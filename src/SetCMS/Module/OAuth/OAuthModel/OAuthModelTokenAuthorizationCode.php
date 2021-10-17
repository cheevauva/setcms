<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\OAuth\OAuthToken;

class OAuthModelTokenAuthorizationCode extends OAuthModel
{

    public string $code = '';
    public string $redirect_uri = '';
    public string $client_id = '';

    protected function validate(): void
    {
        if (empty($this->client_id)) {
            $this->addMessageAsValidation('client_id is required', 'invalid_request');
        }

        if (empty($this->redirect_uri)) {
            $this->addMessageAsValidation('redirect_uri is required', 'invalid_request');
        }

        if (empty($this->code)) {
            $this->addMessageAsValidation('code is required', 'invalid_request');
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
