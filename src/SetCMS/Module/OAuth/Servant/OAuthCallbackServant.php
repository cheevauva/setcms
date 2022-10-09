<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByClientIdDAO;
use SetCMS\Module\OAuth\Servant\OAuthRetrieveTokenByAuthorizationCodeAndClientServant;

class OAuthCallbackServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public string $clientId;
    public string $code;
    public ?string $cmsToken;
    public ?OAuthTokenEntity $oauthToken = null;

    public function serve(): void
    {
        $retrieveClientById = OAuthClientEntityRetrieveByClientIdDAO::make($this->factory());
        $retrieveClientById->clientId = $this->clientId;
        $retrieveClientById->serve();

        if (!$retrieveClientById->oauthClient->isAuthorizable) {
            throw new \Exception('Приложение недоступно для авторизации');
        }

        $retriveTokenByCodeAndClient = OAuthRetrieveTokenByAuthorizationCodeAndClientServant::make($this->factory());
        $retriveTokenByCodeAndClient->client = $retrieveClientById->oauthClient;
        $retriveTokenByCodeAndClient->code = $this->code;
        $retriveTokenByCodeAndClient->serve();

        $this->oauthToken = $retriveTokenByCodeAndClient->token;
    }

}
