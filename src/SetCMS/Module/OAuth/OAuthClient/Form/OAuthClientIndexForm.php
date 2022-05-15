<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Form;

use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbRetrieveManyDAO;

class OAuthClientIndexForm extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    public ?\Iterator $oauthClients = null;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof OAuthClientEntityDbRetrieveManyDAO) {
            $this->oauthClients = $object->entities;
        }
    }
    
    public function toArray(): array
    {
        return [
            'entities' => $this->oauthClients,
        ];
    }

}
