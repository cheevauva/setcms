<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\OAuth\OAuthTokenExeption;
use SetCMS\Module\OAuth\OAuthTokenDAO;

class OAuthTokenDAO extends OrdinaryDAO
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        
    }

    protected function getException(): OAuthTokenExeption
    {
        return new OAuthTokenExeption;
    }

    protected function getTableName(): string
    {
        
    }

    protected function record2entity(array $record): OAuthToken
    {
        
    }

}
