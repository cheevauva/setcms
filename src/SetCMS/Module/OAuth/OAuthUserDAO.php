<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\OAuth\OAuthUser;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\OAuth\OAuthUserException;

class OAuthUserDAO extends OrdinaryDAO
{
    public function getByExternalIdAndClient(string $externalId, OAuthClient $oauthClient): OAuthUser
    {
        return $this->getBy([
            'external_id' => $externalId,
            'client_id' => $oauthClient->id,
        ]);
    }
    

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof OAuthUser);
        
        $record['client_id'] = $entity->clientId;
        $record['external_id'] = $entity->externalId;
        $record['user_id'] = $entity->userId;
        $record['refresh_token'] = $entity->refreshToken;
        
        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function getException(): OAuthUserException
    {
        return new OAuthUserException;
    }

    protected function getTableName(): string
    {
        return 'oauth_users';
    }

    protected function record2entity(array $record): OAuthUser
    {
        $entity = new OAuthUser;
        $entity->clientId = $record['client_id'];
        $entity->externalId = $record['external_id'];
        $entity->userId = $record['user_id'];
        $entity->refreshToken = $record['refresh_token'];
        
        return $this->ordinaryRecord2EntityBind($record, $entity);
    }

}
