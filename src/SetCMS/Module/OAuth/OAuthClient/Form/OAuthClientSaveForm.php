<?php

namespace SetCMS\Module\OAuth\OAuthClient\Form;

use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientSaveForm extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    public string $id;
    public string $name;
    public string $clientId;
    public string $clientSecret;
    public string $redirectURI;
    public string $loginUrl;
    public ?string $autorizationCodeUrl = null;
    public bool $isAuthorizable = false;
    public ?string $userInfoParserRule = null;
    public ?string $userInfoUrl = null;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof OAuthClientEntityDbRetrieveByIdDAO) {
            $object->id = $this->id;
            if ($object->oauthClient) {
                $this->apply($object->oauthClient);
            }
        }

        if ($object instanceof OAuthClientEntity) {
            $this->name = $object->name;
            $this->autorizationCodeUrl = $object->autorizationCodeUrl;
        }
    }

}
