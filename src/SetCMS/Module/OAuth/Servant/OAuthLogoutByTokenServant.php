<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntityRetrieveByAccessTokenDAO;
use SetCMS\Module\OAuth\OAuthToken\DAO\OAuthTokenEntitySaveDAO;

class OAuthLogoutByTokenServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;

    public string $token;

    public function serve(): void
    {
        $retrieveToken = OAuthTokenEntityRetrieveByAccessTokenDAO::make($this->factory());
        $retrieveToken->accessToken = $this->token;
        $retrieveToken->serve();

        $retrieveToken->entity->markDeleted();
        
        $saveToken = OAuthTokenEntitySaveDAO::make($this->factory());
        $saveToken->entity = $retrieveToken->entity;
        $saveToken->serve();
    }

}
