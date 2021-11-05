<?php

namespace SetCMS\Module\OAuth\OAuthModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class OAuthModelLogin extends OrdinaryModel
{

    private array $clients = [];

    public function oauthClients(?array $clients = null): array
    {
        if (is_array($clients)) {
            $this->clients = $clients;
        }

        return $this->clients;
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['clients'] = $this->clients;

        return $array;
    }

}
