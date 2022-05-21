<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\Servant;

use SetCMS\Module\User\UserEntity;
use SetCMS\Module\OAuth\OAuthUser\OAuthUserEntity;
use SetCMS\Module\OAuth\OAuthUser\DAO\OAuthUserEntityDbSaveDAO;
use SetCMS\Module\User\Event\UserAfterRegistrationEvent;

class OAuthUserCreateByUserServant implements \SetCMS\ServantInterface
{

    use \SetCMS\FactoryTrait;

    private OAuthUserEntityDbSaveDAO $save;
    public UserEntity $user;

    public function serve(): void
    {
        $oauthClient = OAuthClientEntityDbRetrieveSetCMSDAO::factory($this->factory);
        $oauthClient->throwExceptions = true;
        $oauthClient->serve();

        $oauthUser = new OAuthUserEntity;
        $oauthUser->clientId = $oauthClient->oauthClient->id;
        $oauthUser->userId = $this->user->id;
        $oauthUser->externalId = $this->user->id;

        $this->save->entity = $oauthUser;
        $this->save->serve();
    }

    public function __invoke(...$params)
    {
        $event = ($params[0] ?? null);

        if ($event instanceof UserAfterRegistrationEvent) {
            $this->user = $event->user;
            $this->serve();
        }
    }

}
