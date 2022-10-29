<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\Servant;

use SetCMS\Module\OAuth\OAuthToken\OAuthTokenEntity;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\Servant\OAuthRetrieveTokenByCodeAndClientServant;
use SetCMS\UUID;

class OAuthCallbackServant implements \SetCMS\ServantInterface
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    public UUID $oauthClientId;
    public string $code;
    public ?string $cmsToken;
    public ?OAuthTokenEntity $oauthToken = null;

    public function serve(): void
    {
        $retrieveById = OAuthClientEntityRetrieveByIdDAO::make($this->factory());
        $retrieveById->id = $this->oauthClientId;
        $retrieveById->serve();

        if (!$retrieveById->oauthClient->isAuthorizable) {
            throw new \Exception('Приложение недоступно для авторизации');
        }

        $retriveTokenByCodeAndClient = OAuthRetrieveTokenByCodeAndClientServant::make($this->factory());
        $retriveTokenByCodeAndClient->client = $retrieveById->oauthClient;
        $retriveTokenByCodeAndClient->code = $this->code;
        $retriveTokenByCodeAndClient->serve();

        $this->oauthToken = $retriveTokenByCodeAndClient->token;
    }

}
