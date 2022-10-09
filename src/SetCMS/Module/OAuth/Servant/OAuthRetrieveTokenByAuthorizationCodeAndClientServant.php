<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientSetCMSEntity;
use SetCMS\Module\OAuth\Servant\OAuthGenerateTokenByAuthorizationCodeServant;
use SetCMS\Module\OAuth\DAO\OAuthRetrieveTokenByAuthorizationCodeAndClientDAO;
use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;

class OAuthRetrieveTokenByAuthorizationCodeAndClientServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public OAuthClientEntity $client;
    public string $code;
    public ?OAuthTokenEntity $token;

    public function serve(): void
    {
        if ($this->client instanceof OAuthClientSetCMSEntity) {
            $generateToken = OAuthGenerateTokenByAuthorizationCodeServant::make($this->factory());
        } else {
            $generateToken = OAuthRetrieveTokenByAuthorizationCodeAndClientDAO::make($this->factory());
        }

        $generateToken->code = $this->code;
        $generateToken->client = $this->client;
        $generateToken->serve();
        
        $this->token = $generateToken->token;
    }

}
