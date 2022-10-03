<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;

class OAuthTokenEntityRetrieveByAccessTokenDAO
{

    use \SetCMS\FactoryTrait;

    public string $accessToken;
    
    public ?OAuthTokenEntity $oauthToken = null;

}
