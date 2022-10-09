<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\DAO;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientException;

class OAuthRetrieveTokenByAuthorizationCodeAndClientDAO implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

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

        $externalId = $this->getExternalId($oauthData, $oauthClient);

        if (empty($externalId)) {
            throw OAuthClientException::internalError('externalId empty');
        }

        try {
            $user = $this->getUserByAccessToken((string) $this->cmsToken);

            try {
                $oauthUser = $this->oauthUserDAO->getByExternalIdAndClient($externalId, $oauthClient);
            } catch (NotFound $ex) {
                $oauthUser = new OAuthUser;
            }
        } catch (NotFound $ex) {
            try {
                $oauthUser = $this->oauthUserDAO->getByExternalIdAndClient($externalId, $oauthClient);
                $user = $this->userService->getById($oauthUser->userId);
            } catch (NotFound $ex) {
                $oauthUser = new OAuthUser;
                $user = $this->userService->createUser($oauthClient->name . $externalId, microtime(true));
            }
        }

        $oauthUser->oauthClientId = $oauthClient->id;
        $oauthUser->externalId = $externalId;
        $oauthUser->userId = $user->id;
        $oauthUser->refreshToken = $oauthData['refresh_token'] ?? '';

        $this->oauthUserDAO->save($oauthUser);

        $oauthToken = $this->generateToken($user, $oauthClient, '+1 year');
    }

    public function getExternalId($oauthData, OAuthClient $oauthClient)
    {
        $externalId = $this->getValueFromNestedArrayByPath($oauthData, $oauthClient->userInfoParserRule);

        if (!empty($externalId)) {
            return $externalId;
        }

        $data = $this->oauthClientDAO->getResource($oauthClient->userInfoUrl, $oauthData);

        return $this->getValueFromNestedArrayByPath($data, $oauthClient->userInfoParserRule);
    }

    public function getUserByAccessToken(string $token): User
    {
        $oauthToken = $this->oauthTokenDAO->getByAccessToken($token);
        $user = $this->userService->getById($oauthToken->userId);

        return $user;
    }

}
