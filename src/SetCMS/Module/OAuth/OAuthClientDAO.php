<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\OAuth\OAuthClientException;
use SetCMS\Module\OAuth\OAuthClient;

class OAuthClientDAO extends OrdinaryDAO
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        $record = [];
        $record['name'] = $entity->name;
        
        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function getException(): OAuthClientException
    {
        return new OAuthClientException;
    }

    protected function getTableName(): string
    {
        return 'oauth_clients';
    }

    protected function record2entity(array $record): OAuthClient
    {
        $client = new OAuthClient;
        $client->name = $record['name'];
        
        return $this->ordinaryRecord2EntityBind($record, $client);
    }

}
