<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Scope;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

trait OAuthClientPrivateSaveScopeTrait
{

    public string $name;
    public string $clientId;
    public string $clientSecret;
    public string $redirectURI;
    public string $loginUrl;
    public bool $isAuthorizable = false;

    public function satisfy(): \Iterator
    {
        if (isset($this->callbackId) && ($this->callbackId < 1000 || $this->callbackId > 9999)) {
            yield ['Идентификатор возврата должен быть числом от 1000 до 9999', 'callbackId'];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof OAuthClientEntity) {
            $object->name = $this->name;
            $object->redirectURI = $this->redirectURI;
            $object->loginUrl = $this->loginUrl;
            $object->clientId = $this->clientId;
            $object->clientSecret = $this->clientSecret;
            $object->isAuthorizable = $this->isAuthorizable;
        }
    }

}
