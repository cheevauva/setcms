<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntityDbSaveDAO;
use SetCMS\Module\User\UserEntity;

class OAuthGenerateTokenServant implements \SetCMS\ServantInterface
{

    private OAuthTokenEntityDbSaveDAO $saveToken;
    public OAuthClientEntity $client;
    public UserEntity $user;
    public ?OAuthTokenEntity $token = null;

    public function serve(): void
    {
        $this->token = new OAuthTokenEntity;
        $this->token->dateExpiried = new \DateTime('+1 hour');
        $this->token->clientId = $this->client->id;
        $this->token->userId = $this->user->id;

        $this->saveToken->entity = $this->token;
        $this->saveToken->serve();
    }

}
