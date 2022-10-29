<?php

namespace SetCMS\Module\OAuth\OAuthClient\Form;

use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientSaveForm extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{



    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof OAuthClientEntityRetrieveByIdDAO) {
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
