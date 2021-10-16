<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\OAuth\OAuthTokenExeption;
use SetCMS\Module\OAuth\OAuthToken;

class OAuthTokenDAO extends OrdinaryDAO
{

    public function getByRefreshTokenAndClientId(string $refreshToken, string $clientId): OAuthToken
    {
        return $this->getBy([
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
        ]);
    }

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof OAuthToken);

        $record['token'] = $entity->token;
        $record['refresh_token'] = $entity->tokenRefresh;
        $record['client_id'] = $entity->idClient;
        $record['user_id'] = $entity->idUser;
        $record['date_expired'] = $entity->dateExpiried->format('Y-m-d H:i:s');

        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function getException(): OAuthTokenExeption
    {
        return new OAuthTokenExeption;
    }

    protected function getTableName(): string
    {
        return 'oauth_tokens';
    }

    protected function record2entity(array $record): OAuthToken
    {
        $entity = new OAuthToken;
        $entity->token = $record['token'];
        $entity->tokenRefresh = $record['refresh_token'];
        $entity->idClient = $record['client_id'];
        $entity->idUser = $record['user_id'];
        $entity->dateExpiried = new \DateTime($record['date_expired']);
        
        return $this->ordinaryRecord2EntityBind($record, $entity);
    }

}
