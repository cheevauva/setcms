<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientDAO;
use SetCMS\Module\OAuth\OAuthTokenDAO;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelCallback;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenPassword;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenRefreshToken;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenAuthorizationCode;
use SetCMS\HttpStatusCode\NotFound;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\User;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\OAuth\OAuthCode;
use SetCMS\Module\OAuth\OAuthCodeDAO;
use SetCMS\Module\Users\UserException;
use SetCMS\Module\OAuth\OAuthClientException;
use SetCMS\Module\OAuth\OAuthUserDAO;
use SetCMS\Module\OAuth\OAuthUserException;

class OAuthService
{

    private OAuthClientDAO $oauthClientDAO;
    private OAuthTokenDAO $oauthTokenDAO;
    private OAuthCodeDAO $oauthCodeDAO;
    private OAuthUserDAO $oauthUserDAO;
    private UserService $userService;

    public function __construct(OAuthClientDAO $oauthClientDAO, OAuthTokenDAO $oauthTokenDAO, UserService $userService, OAuthCodeDAO $oauthCodeDAO, OAuthUserDAO $oauthUserDAO)
    {
        $this->oauthClientDAO = $oauthClientDAO;
        $this->oauthTokenDAO = $oauthTokenDAO;
        $this->oauthCodeDAO = $oauthCodeDAO;
        $this->oauthUserDAO = $oauthUserDAO;
        $this->userService = $userService;
    }

    public function generateToken(User $user, OAuthClient $oauthClient, string $duration = '+1 hour'): OAuthToken
    {
        $oauthToken = new OAuthToken;
        $oauthToken->token = OAuthToken::generateToken();
        $oauthToken->tokenRefresh = OAuthToken::generateToken();
        $oauthToken->dateExpiried = new \DateTime('+1 hour');
        $oauthToken->idClient = $oauthClient->id;
        $oauthToken->idUser = $user->id;

        $this->oauthTokenDAO->save($oauthToken);

        return $oauthToken;
    }

    public function regenerateToken(OAuthToken $oauthToken): OAuthToken
    {
        $oauthToken->token = OAuthToken::generateToken();
        $oauthToken->dateExpiried = new \DateTime('+1 hour');
        $oauthToken->dateModified = new \DateTime;

        $this->oauthTokenDAO->save($oauthToken);

        return $oauthToken;
    }

    public function refreshToken(OAuthModelTokenRefreshToken $model): void
    {
        try {
            $oauthToken = $this->oauthTokenDAO->getByRefreshTokenAndClientId($model->refresh_token, $model->client_id);

            $model->entity($this->regenerateToken($oauthToken));
        } catch (NotFound $ex) {
            $model->addMessage($ex->getMessage(), 'unauthorized_client');
        }
    }

    public function tokenByPassword(OAuthModelTokenPassword $model): void
    {
        try {
            $oauthClient = $this->oauthClientDAO->getById($model->client_id);
            $user = $this->userService->getByUsernameAndPassword($model->username, $model->password);

            $model->entity($this->generateToken($user, $oauthClient));
        } catch (NotFound $ex) {
            $model->addMessage($ex->getMessage(), 'unauthorized_client');
        }
    }

    public function tokenByAuthorizationCode(OAuthModelTokenAuthorizationCode $model): void
    {
        $oauthClient = $this->oauthClientDAO->getById($model->client_id);
        $oauthCode = $this->oauthCodeDAO->getByCodeAndClientId($model->code, $oauthClient->id);
        $user = $this->userService->getById($oauthCode->userId);

        $model->entity($this->generateToken($user, $oauthClient));

        $this->oauthCodeDAO->remove($oauthCode);
    }

    public function parseTokens(array $tokens): array
    {
        $parsedTokens = [];

        foreach ($tokens as $token) {
            $parsed = array_filter(explode(' ', $token, 2));

            if (empty($parsed)) {
                continue;
            }

            if (count($parsed) === 1) {
                $parsedTokenType = 'Bearer';
                $parsedToken = reset($parsed);
            } else {
                list($parsedTokenType, $parsedToken) = $parsed;
            }

            switch ($parsedTokenType) {
                case 'Bearer':
                    $parsedTokens[] = $parsedToken;
                    break;
            }
        }

        return $parsedTokens;
    }

    public function removeToken(string $token)
    {
        $oauthToken = $this->oauthTokenDAO->getByAccessToken($token);

        $this->oauthTokenDAO->remove($oauthToken);
    }

    public function getUserByAccessToken(string $token): User
    {
        $oauthToken = $this->oauthTokenDAO->getByAccessToken($token);
        $user = $this->userService->getById($oauthToken->idUser);

        return $user;
    }

    public function generateAuthorizationCode(User $user, OAuthClient $oauthClient): OAuthCode
    {
        $oauthCode = new OAuthCode;
        $oauthCode->clientId = $oauthClient->id;
        $oauthCode->userId = $user->id;
        $oauthCode->code = OAuthCode::generateCode();

        $this->oauthCodeDAO->save($oauthCode);

        return $oauthCode;
    }

    public function callback(OAuthModelCallback $model): void
    {
        $oauthClient = $this->oauthClientDAO->getById($model->client_id);
        $oauthData = $this->oauthClientDAO->getTokenByAuthorizationCodeAndClient($model->code, $oauthClient);

        assert($oauthClient instanceof OAuthClient);

        $externalId = $this->oauthClientDAO->getExternalId($oauthData, $oauthClient);

        if (empty($externalId)) {
            throw OAuthClientException::internalError('externalId empty');
        }

        try {
            $user = $this->getUserByAccessToken((string) $model->cms_token);

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

        $oauthUser->clientId = $oauthClient->id;
        $oauthUser->externalId = $externalId;
        $oauthUser->userId = $user->id;
        $oauthUser->refreshToken = $oauthData['refresh_token'] ?? '';

        $this->oauthUserDAO->save($oauthUser);

        $oauthToken = $this->generateToken($user, $oauthClient, '+1 year');

        $model->entity($oauthToken);
    }

    public function authorize(OAuthModelAuthorize $model): void
    {
        try {
            $client = $this->oauthClientDAO->getById($model->client_id);
        } catch (OAuthClientException $ex) {
            $model->addMessage($ex->getMessage(), 'client_id');
        }

        try {
            $user = $this->userService->getByUsernameAndPassword($model->username, $model->password);
        } catch (UserException $ex) {
            $model->addMessage($ex->getMessage(), 'username');
        }

        if (!empty($user) && !empty($client)) {
            $model->entity($this->generateAuthorizationCode($user, $client));
        }
    }

    public function getClientsWithEnabledAuthorization(): array
    {
        return $this->oauthClientDAO->list(0, 10);
    }

}
