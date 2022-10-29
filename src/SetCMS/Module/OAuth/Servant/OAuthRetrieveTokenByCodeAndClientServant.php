<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientSetCMSEntity;
use SetCMS\Module\OAuth\Servant\OAuthGenerateTokenByAuthorizationCodeServant;
use SetCMS\Module\OAuth\DAO\OAuthRetrieveTokenByCodeAndOAuthClientDAO;
use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\Servant\OAuthGenerateTokenServant;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthCode\DAO\OAuthCodeEntityRetrieveByCodeAndClientIdDAO;

class OAuthRetrieveTokenByCodeAndClientServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public OAuthClientEntity $client;
    public string $code;
    public ?OAuthTokenEntity $token;

    public function serve(): void
    {
        if ($this->client instanceof OAuthClientSetCMSEntity) {
            $generateToken = OAuthCodeEntityRetrieveByCodeAndClientIdDAO::make($this->factory());
        } else {
            $generateToken = OAuthRetrieveTokenByCodeAndOAuthClientDAO::make($this->factory());
        }

        $generateToken->code = $this->code;
        $generateToken->oauthClient = $this->client;
        $generateToken->serve();

        $this->token = $generateToken->accessToken;
    }

    public function serve2(): void
    {
        $retrieveUserById = UserEntityDbRetrieveByIdDAO::make($this->factory());
        $retrieveUserById->id = $retrieveOAuthCodeByCodeAndClientId->oauthCode->userId;
        $retrieveUserById->serve();

        $generateToken = OAuthGenerateTokenServant::make($this->factory());
        $generateToken->user = $retrieveUserById->entity;
        $generateToken->client = $this->client;
        $generateToken->serve();

        $this->token = $generateToken->token;

        $externalId = $this->getExternalId($this->data, $this->client);

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

    public function getExternalId(array $oauthData, OAuthClientEntity $oauthClient)
    {
        $externalId = $this->getValueFromNestedArrayByPath($oauthData, 'id');

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
