<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\OAuth\OAuthCode;
use SetCMS\Module\OAuth\OAuthCodeException;

class OAuthCodeDAO extends OrdinaryDAO
{

    public function getByCodeAndClientId(string $code, string $clientId): OAuthCode
    {
        return $this->getBy([
            'code' => $code,
            'client_id' => $clientId,
        ]);
    }
    
    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof OAuthCode);

        $record['code'] = $entity->code;
        $record['client_id'] = $entity->clientId;
        $record['user_id'] = $entity->userId;

        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function getException(): OAuthCodeException
    {
        return new OAuthCodeException;
    }

    protected function getTableName(): string
    {
        return 'oauth_codes';
    }

    protected function record2entity(array $record): OAuthCode
    {
        $entity = new OAuthCode;
        $entity->code = $record['code'];
        $entity->clientId = $record['client_id'];
        $entity->userId = $record['user_id'];

        return $this->ordinaryRecord2EntityBind($record, $entity);
    }

}
