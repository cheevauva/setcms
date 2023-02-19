<?php

namespace SetCMS\Module\OAuth\Scope;

use SetCMS\UUID;
use SetCMS\Module\OAuth\Servant\OAuthAuthorizeWithCaptchaServant;
use SetCMS\Module\OAuth\OAuthAppCode\OAuthAppCodeEntity;

class OAuthDoAuthorizeScope extends \SetCMS\Scope
{

    private ?OAuthAppCodeEntity $OAuthAppCode = null;
    public string $client_id;
    public string $response_type;
    public string $redirect_uri;
    public string $username;
    public string $password;

    //public UUID $captcha;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof OAuthAuthorizeWithCaptchaServant) {
            $object->username = $this->username;
            $object->password = $this->password;
            //$object->captcha = $this->captcha;
            $object->clientId = $this->client_id;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof OAuthAuthorizeWithCaptchaServant) {
            $this->OAuthAppCode = $object->oauthAppCode;
        }
    }

    public function toArray(): array
    {
        return [
            'code' => $this->OAuthAppCode->code ?? null,
            'clientId' => $this->client_id,
        ];
    }

}
