<?php

namespace SetCMS\Module\OAuth;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\OAuth\OAuthClientException;
use SetCMS\Module\OAuth\OAuthClient;

class OAuthClientDAO extends OrdinaryDAO
{

    public function getResource(string $url, array $oauthData): ?array
    {
        $preparedUrl = strtr($url, [
            '{accessToken}' => $oauthData['access_token'],
        ]);

        $response = (new Client())->request('GET', $preparedUrl, [
            RequestOptions::HTTP_ERRORS => false,
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Authorization' => implode(' ', array_filter([$oauthData['token_type'] ?? null, $oauthData['access_token']]))
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if (!empty($data['error'])) {
            throw OAuthClientException::autorizationCodeFail($data['error_description'] ?? json_encode($data, JSON_UNESCAPED_UNICODE));
        }

        return $data;
    }

    public function getTokenByAuthorizationCodeAndClient(string $code, OAuthClient $oauthClient): array
    {
        try {
            $response = (new Client())->request('POST', $oauthClient->autorizationCodeUrl, [
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $oauthClient->redirectURI,
                    'client_id' => $oauthClient->clientId,
                    'client_secret' => $oauthClient->clientSecret,
                ],
                RequestOptions::HTTP_ERRORS => true,
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                ],
            ]);
        } catch (GuzzleException $ex) {
            throw OAuthClientException::autorizationCodeFail($ex->getMessage());
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $response->getBody()->rewind();
            throw OAuthClientException::autorizationCodeFail($response->getBody()->getContents());
        }

        if (!empty($data['error'])) {
            throw OAuthClientException::autorizationCodeFail($data['error_description']);
        }

        return $data;
    }

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
