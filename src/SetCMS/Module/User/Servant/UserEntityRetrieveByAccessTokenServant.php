<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\FactoryInterface;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntityDbRetrieveByIdDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;

class UserEntityRetrieveByAccessTokenServant implements ServantInterface
{

    private OAuthTokenEntityDbRetrieveByIdDAO $retrieveToken;
    private UserEntityDbRetrieveByIdDAO $retrieveUser;
    public string $accessToken;
    public ?UserEntity $user = null;

    public function __construct(FactoryInterface $factory)
    {
        $this->retrieveToken = $factory->make(OAuthTokenEntityDbRetrieveByIdDAO::class);
        $this->retrieveUser = $factory->make(UserEntityDbRetrieveByIdDAO::class);
    }

    public function serve(): void
    {
        $this->retrieveToken->id = $this->accessToken;
        $this->retrieveToken->serve();

        $this->retrieveUser->id = $this->retrieveToken->oauthToken->userId;
        $this->retrieveUser->serve();

        $this->user = $this->retrieveUser->entity;
    }

}
