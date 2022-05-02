<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

class OAuthClientEntityDbMapper
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof OAuthClient);

        $record = [];
        $record['name'] = $entity->name;
        $record['client_id'] = $entity->clientId;
        $record['client_secret'] = $entity->clientSecret;
        $record['redirect_uri'] = $entity->redirectURI;
        $record['login_url'] = $entity->loginUrl;
        $record['autorization_code_url'] = $entity->autorizationCodeUrl;
        $record['userinfo_url'] = $entity->userInfoUrl;
        $record['is_authorizable'] = (int) $entity->isAuthorizable;
        $record['userinfo_parser_rule'] = $entity->userInfoParserRule;

        return $this->ordinaryEntity2RecordBind($entity, $record);
    }

    protected function record2entity(array $record): OAuthClient
    {
        $client = new OAuthClient;
        $client->name = $record['name'];
        $client->clientId = $record['client_id'];
        $client->clientSecret = $record['client_secret'];
        $client->redirectURI = $record['redirect_uri'] ?? '';
        $client->loginUrl = $record['login_url'] ?? '';
        $client->autorizationCodeUrl = $record['autorization_code_url'];
        $client->isAuthorizable = !empty($record['is_authorizable']);
        $client->userInfoUrl = $record['userinfo_url'] ?? '';
        $client->userInfoParserRule = $record['userinfo_parser_rule'] ?? '';

        return $this->ordinaryRecord2EntityBind($record, $client);
    }

}
