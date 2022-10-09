<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\Servant\OAuthGenerateTokenServant;
use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthCode\DAO\OAuthCodeEntityRetrieveByCodeAndClientIdDAO;
use SetCMS\Module\User\DAO\UserEntityDbRetrieveByIdDAO;

class OAuthGenerateTokenByAuthorizationCodeServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public OAuthClientEntity $client;
    public string $code;
    public ?OAuthTokenEntity $token = null;

    public function serve(): void
    {
        $retrieveOAuthCodeByCodeAndClientId = OAuthCodeEntityRetrieveByCodeAndClientIdDAO::make($this->factory());
        $retrieveOAuthCodeByCodeAndClientId->oauthClient = $this->client;
        $retrieveOAuthCodeByCodeAndClientId->code = $this->code;
        $retrieveOAuthCodeByCodeAndClientId->serve();
        
        $retrieveUserById = UserEntityDbRetrieveByIdDAO::make($this->factory());
        $retrieveUserById->id = $retrieveOAuthCodeByCodeAndClientId->oauthCode->userId;
        $retrieveUserById->serve();
        
        $generateToken = OAuthGenerateTokenServant::make($this->factory());
        $generateToken->user = $retrieveUserById->entity;
        $generateToken->client = $this->client;
        $generateToken->serve();

        $this->token = $generateToken->token;
    }

}
