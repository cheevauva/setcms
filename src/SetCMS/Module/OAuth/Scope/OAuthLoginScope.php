<?php

namespace SetCMS\Module\OAuth\Scope;

use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveManyDAO;

class OAuthLoginScope extends \SetCMS\Scope implements \SetCMS\Contract\Twigable
{

    private array $clients = [];

    public function from(object $object): void
    {
        parent::from($object);
        
        if ($object instanceof OAuthClientEntityRetrieveManyDAO) {
            $this->clients = iterator_to_array($object->entities);
        }
    }
    
    public function toArray(): array
    {
        $array = parent::toArray();
        $array['clients'] = $this->clients;

        return $array;
    }

}
