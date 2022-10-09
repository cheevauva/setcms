<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntitySaveDAO;
use SetCMS\Module\User\UserEntity;

class OAuthGenerateTokenServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public OAuthClientEntity $client;
    public UserEntity $user;
    public ?OAuthTokenEntity $token = null;

    public function serve(): void
    {
        $token = new OAuthTokenEntity;
        $token->dateExpiried = new \DateTime('+1 hour');
        $token->clientId = $this->client->id;
        $token->userId = $this->user->id;

        $saveToken = OAuthTokenEntitySaveDAO::make($this->factory());
        $saveToken->entity = $token;
        $saveToken->serve();
        
        $this->token = $token;
    }

}
