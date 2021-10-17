<?php

namespace SetCMS\Module\OAuth\OAuthModel;

class OAuthModelCallback extends \SetCMS\Model
{

    /**
     * @setcms-required
     * @var string 
     */
    public string $client_id = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $code = '';
    private array $token = [];

    public function token(array $token = null): array
    {
        if (is_array($token)) {
            $this->token = $token;
        }

        return $this->token;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
        ];
    }

}
