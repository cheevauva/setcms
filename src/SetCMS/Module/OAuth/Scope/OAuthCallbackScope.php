<?php

namespace SetCMS\Module\OAuth\Scope;

use SetCMS\Module\OAuth\Servant\OAuthCallbackServant;
use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\UUID;

class OAuthCallbackScope extends \SetCMS\Scope
{

    public UUID $id;
    public string $code;
    public ?string $cms_token = null;
    private ?OAuthTokenEntity $token = null;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof OAuthCallbackServant) {
            $object->oauthClientId = $this->id;
            $object->code = $this->code;
            $object->cmsToken = $this->cms_token;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof OAuthCallbackServant) {
            $this->token = $object->oauthToken;
        }
    }

    public function toArray(): array
    {
        return $this->token ? [
            'token' => $this->token->token,
            'refresh_token' => $this->token->refreshToken,
            'date_expiried' => $this->token->dateExpiried->format('Y-m-d H:i:s'),
        ] : [];
    }

}
