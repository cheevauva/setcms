<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

class OAuthClientRetrieveTokenByAuthorizationCodeAndClientDAO implements \SetCMS\ServantInterface
{

    public OAuthClientEntity $oauthClient;
    public string $code;
    public ?array $data = null;

    public function serve(): void
    {
        try {
            $response = (new Client())->request('POST', $this->oauthClient->autorizationCodeUrl, [
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'authorization_code',
                    'code' => $this->code,
                    'redirect_uri' => $this->oauthClient->redirectURI,
                    'client_id' => $this->oauthClient->clientId,
                    'client_secret' => $this->oauthClient->clientSecret,
                ],
                RequestOptions::HTTP_ERRORS => true,
                RequestOptions::HEADERS => [
                //'Content-type' => 'application/json',
                ],
            ]);
        } catch (GuzzleException $ex) {
            throw OAuthClientException::autorizationCodeFail($ex->getMessage());
        }

        $this->data = json_decode($response->getBody()->getContents(), true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            $response->getBody()->rewind();
            throw OAuthClientException::autorizationCodeFail($response->getBody()->getContents());
        }

        if (!empty($this->data['error'])) {
            throw OAuthClientException::autorizationCodeFail($this->data['error_description']);
        }
    }

}
