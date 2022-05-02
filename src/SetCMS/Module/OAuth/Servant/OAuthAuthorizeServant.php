<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthCode\OAuthCodeEntity;
use SetCMS\Module\OAuth\OAuthCode\DAO\OAuthCodeEntityDbSaveDAO;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientException;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByUsernameAndPasswordDAO;

class OAuthAuthorizeServant implements \SetCMS\ServantInterface
{

    private OAuthClientEntityDbRetrieveByIdDAO $retrieveOAuthClient;
    private OAuthCodeEntityDbSaveDAO $saveOAuthCode;
    private UserEntityDbRetrieveByUsernameAndPasswordDAO $retrieveUser;
    public string $clientId;
    public string $username;
    public string $password;
    public ?OAuthCodeEntity $oauthCode = null;

    public function serve(): void
    {
        $this->retrieveOAuthClient->id = $this->clientId;
        $this->retrieveOAuthClient->serve();

        $this->retrieveUser->username = $this->username;
        $this->retrieveUser->password = $this->password;
        $this->retrieveUser->serve();

        $user = $this->retrieveUser->entity;
        $client = $this->retrieveOAuthClient->oauthClient;

        if (!$client->isAuthorizable) {
            throw OAuthClientException::autorizationNotAllow();
        }

        $this->oauthCode = new OAuthCodeEntity;
        $this->oauthCode->userId = $user->id;
        $this->oauthCode->clientId = $client->id;

        $this->saveOAuthCode->entity = $this->oauthCode;
        $this->saveOAuthCode->serve();
    }

}
