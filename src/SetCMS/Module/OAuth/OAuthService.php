<?php

namespace SetCMS\Module\OAuth;

use SetCMS\Module\OAuth\OAuthModel\OAuthAuthorizeScope;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenPassword;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenRefreshToken;
use SetCMS\Module\OAuth\OAuthModel\OAuthModelTokenAuthorizationCode;
use SetCMS\HttpStatusCode\NotFound;
use SetCMS\Module\Users\User;
use SetCMS\Module\OAuth\OAuthClient;
use SetCMS\Module\OAuth\OAuthAppCode;
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

        //$this->OAuthAppCodeDAO->remove($OAuthAppCode->id);
    }

    public function removeToken(string $token)
    {
        $oauthToken = $this->oauthTokenDAO->getByAccessToken($token);

        $this->oauthTokenDAO->remove($oauthToken->id);
    }


    public function generateAuthorizationCode(User $user, OAuthClient $oauthClient): OAuthAppCode
    {
        $OAuthAppCode = new OAuthAppCode;
        $OAuthAppCode->oauthClientId = $oauthClient->id;
        $OAuthAppCode->userId = $user->id;

        $this->OAuthAppCodeDAO->save($OAuthAppCode);

        return $OAuthAppCode;
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



    public function checkThePossibilityOfAuthorization(OAuthAuthorizeScope $model): void
    {
        $oauthClient = $this->oauthClientDAO->get($model->client_id);

        if (!$oauthClient->isAuthorizable) {
            throw OAuthClientException::autorizationNotAllow();
        }
    }

}
