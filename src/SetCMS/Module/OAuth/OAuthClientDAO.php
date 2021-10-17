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

    public function getTokenByAuthorizationCodeAndClient(string $code, OAuthClient $oauthClient): array
    {
        try {
            $response = (new Client())->request('POST', $oauthClient->autorizationCodeGrantTypeUrl, [
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => $oauthClient->redirectURI,
                    'client_id' => $oauthClient->id,
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
        $record['login_url'] = $entity->loginURL;

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
        $client->loginURL = $record['login_url'] ?? '';

        return $this->ordinaryRecord2EntityBind($record, $client);
    }

}
