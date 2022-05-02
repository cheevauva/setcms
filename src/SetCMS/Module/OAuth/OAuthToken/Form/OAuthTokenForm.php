<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\Form;

class OAuthTokenForm extends \SetCMS\Core\Form
{

    private const GRANT_TYPE_AUTH_CODE = 'authorization_code';
    private const GRANT_TYPE_REFRESH_TOKEN = 'refresh_token';
    private const GRANT_TYPE_PASSWORD = 'password';

    private array $grantTypes = [
        self::GRANT_TYPE_AUTH_CODE,
        self::GRANT_TYPE_REFRESH_TOKEN,
        self::GRANT_TYPE_PASSWORD,
    ];
    public string $grant_type = '';

    protected function validate(): void
    {
        if (empty($this->grant_type)) {
            $this->addMessageAsValidation('grant_type is required', 'invalid_request');
        } else {
            if (!in_array($this->grant_type, $this->grantTypes, true)) {
                $this->addMessageAsValidation(sprintf('grant_type is wrong, must be one of (%s)', implode(', ', $this->grantTypes)), 'invalid_request');
            }
        }
    }

    private function getOAuthModel(): OAuthModel
    {
        switch ($this->grant_type) {
            case self::GRANT_TYPE_PASSWORD;
                return new OAuthModelTokenPassword;
            case self::GRANT_TYPE_REFRESH_TOKEN:
                return new OAuthModelTokenRefreshToken;
            case self::GRANT_TYPE_AUTH_CODE:
                return new OAuthModelTokenAuthorizationCode;
        }
    }

    private function isGrantTypeAuthorizationCode(): bool
    {
        return $this->grant_type === self::GRANT_TYPE_AUTH_CODE;
    }

    private function isGrantTypePassword(): bool
    {
        return $this->grant_type === self::GRANT_TYPE_PASSWORD;
    }

    private function isGrantTypeRefreshToken(): bool
    {
        return $this->grant_type === self::GRANT_TYPE_REFRESH_TOKEN;
    }

}
