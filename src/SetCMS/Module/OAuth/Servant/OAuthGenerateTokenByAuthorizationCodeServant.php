<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;



use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;

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
        

    }

}
