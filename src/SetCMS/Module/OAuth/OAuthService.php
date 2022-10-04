<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthModel\OAuthAuthorizeScope;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenPassword;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenRefreshToken;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenAuthorizationCode;
use SetCMS\HttpStatusCode\NotFound;
use SetCMS\Module\Users\User;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\OAuth\OAuthCode;
use SetCMS\Module\OAuth\OAuthClientException;

class OAuthService
{

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
            $oauthClient = $this->oauthClientDAO->get($model->client_id);
            $user = $this->userService->authenticate($model->username, $model->password);

            $model->entity($this->generateToken($user, $oauthClient));
        } catch (NotFound $ex) {
            $model->addMessage($ex->getMessage(), 'unauthorized_client');
        }
    }

    public function tokenByAuthorizationCode(OAuthModelTokenAuthorizationCode $model): void
    {
        $oauthClient = $this->oauthClientDAO->get($model->client_id);
        $oauthCode = $this->oauthCodeDAO->getByCodeAndClientId($model->code, $oauthClient->id);
        $user = $this->userService->getById($oauthCode->userId);

        $model->entity($this->generateToken($user, $oauthClient));

        //$this->oauthCodeDAO->remove($oauthCode->id);
    }

    public function removeToken(string $token)
    {
        $oauthToken = $this->oauthTokenDAO->getByAccessToken($token);

        $this->oauthTokenDAO->remove($oauthToken->id);
    }

    public function getUserByAccessToken(string $token): User
    {
        $oauthToken = $this->oauthTokenDAO->getByAccessToken($token);
        $user = $this->userService->getById($oauthToken->userId);

        return $user;
    }

    public function generateAuthorizationCode(User $user, OAuthClient $oauthClient): OAuthCode
    {
        $oauthCode = new OAuthCode;
        $oauthCode->clientId = $oauthClient->id;
        $oauthCode->userId = $user->id;

        $this->oauthCodeDAO->save($oauthCode);

        return $oauthCode;
    }

    private function getValueFromNestedArrayByPath(array $array, string $path)
    {
        $address = explode('.', $path);
        $count = count($address);
        $val = $array;

        for ($i = 0; $i < $count; $i++) {
            if (isset($val[$address[$i]])) {
                $val = $val[$address[$i]];
            } else {
                return null;
            }
        }

        return $val;
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

    public function checkThePossibilityOfAuthorization(OAuthAuthorizeScope $model): void
    {
        $oauthClient = $this->oauthClientDAO->get($model->client_id);

        if (!$oauthClient->isAuthorizable) {
            throw OAuthClientException::autorizationNotAllow();
        }
    }

}
