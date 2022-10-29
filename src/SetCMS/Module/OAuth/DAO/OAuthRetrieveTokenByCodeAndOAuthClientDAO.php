<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\DAO;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientException;

class OAuthRetrieveTokenByCodeAndOAuthClientDAO implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public string $code;
    public OAuthClientEntity $oauthClient;
    public ?string $accessToken = null;
    public ?int $expiresIn = null;

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

        $data = json_decode($response->getBody()->getContents(), true, JSON_THROW_ON_ERROR);

        $this->accessToken = $data['access_token'] ?? null;
        $this->expiresIn = $data['expires_in'] ?? null;
    }

}
