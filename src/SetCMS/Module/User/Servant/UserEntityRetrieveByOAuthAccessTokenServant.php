<?php

declare(strict_types=1);

namespace SetCMS\Module\User\Servant;

use SetCMS\ServantInterface;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntityDbRetrieveByIdDAO;

class UserEntityRetrieveByOAuthAccessTokenServant implements ServantInterface
{

    use \SetCMS\DITrait;

    public string $accessToken;
    public ?UserEntity $user = null;

    public function serve(): void
    {
        $retrieveToken = OAuthTokenEntityDbRetrieveByIdDAO::make($this->factory());
        $retrieveToken->id = $this->accessToken;
        $retrieveToken->serve();
        
        $retrieveUser = UserEntityDbRetrieveByIdDAO::make($this->factory());
        $retrieveUser->id = $retrieveToken->oauthToken->userId;
        $retrieveUser->serve();

        $this->user = $retrieveUser->entity;
    }

}
