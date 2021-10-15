<?php

namespace SetCMS\Module\OAuth\OAuthModel;

class OAuthModelToken extends \SetCMS\Model
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
    public string $username = '';
    public string $password = '';
    public string $scope = '';

    protected function validate(): void
    {
        if (empty($this->grant_type)) {
            $this->addMessageAsValidation('grant_type is required', 'invalid_request');
        } else {
            if (!in_array($this->grant_type, $this->grantTypes, true)) {
                $this->addMessageAsValidation(sprintf('grant_type is wrong, must be one of (%s)', implode(', ', $this->grantTypes)), 'invalid_request');
            }
        }

        switch ($this->grant_type) {
            case self::GRANT_TYPE_PASSWORD:
                if (empty($this->password)) {
                    $this->addMessageAsValidation('password is required', 'invalid_request');
                }

                if (empty($this->username)) {
                    $this->addMessageAsValidation('username is required', 'invalid_request');
                }
        }
    }

    public function toArray(): array
    {
        $response = [];

        if ($this->messages) {
            $message = reset($this->messages);
            $response['error'] = $message['field'];
            $response['error_description'] = $message['message'];
        }

        return $response;
    }

}
