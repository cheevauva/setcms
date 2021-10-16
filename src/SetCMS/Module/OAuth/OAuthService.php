<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthClientDAO;
use SetCMS\Module\OAuth\OAuthTokenDAO;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelAuthorize;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenPassword;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenRefreshToken;
use SetCMS\HttpStatusCode\NotFound;
use SetCMS\Module\Users\UserService;
use SetCMS\Module\Users\User;
use SetCMS\Module\OAuth\OAuthClient;

class OAuthService
{

    private OAuthClientDAO $oauthClientDAO;
    private OAuthTokenDAO $oauthTokenDAO;
    private UserService $userService;

    public function __construct(OAuthClientDAO $oauthClientDAO, OAuthTokenDAO $oauthTokenDAO, UserService $userService)
    {
        $this->oauthClientDAO = $oauthClientDAO;
        $this->oauthTokenDAO = $oauthTokenDAO;
        $this->userService = $userService;
    }

    public function generateToken(User $user, OAuthClient $oauthClient): OAuthToken
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

    public function authorize(OAuthModelAuthorize $model): void
    {
        try {
            $client = $this->oauthClientDAO->getById($model->client_id);
        } catch (NotFound $ex) {
            $model->addMessage('client is not exists', 'invalid_client');
        }
    }

}
