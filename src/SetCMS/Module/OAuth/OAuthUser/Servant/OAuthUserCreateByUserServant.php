<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\Servant;

use SetCMS\Module\User\Event\UserRegistrationEvent;
use SetCMS\Module\User\UserEntity;
use SetCMS\Module\OAuth\OAuthUser\OAuthUserEntity;
use SetCMS\Module\OAuth\OAuthUser\DAO\OAuthUserEntitySaveDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\Servant\OAuthClientSetCMSServant;

class OAuthUserCreateByUserServant implements \SetCMS\ServantInterface, \SetCMS\Contract\Applicable
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;

    private OAuthUserEntitySaveDAO $save;
    public UserEntity $user;

    public function serve(): void
    {
        $oauthClient = OAuthClientSetCMSServant::make($this->factory());
        $oauthClient->throwExceptions = true;
        $oauthClient->serve();

        $oauthUser = new OAuthUserEntity;
        $oauthUser->clientId = $oauthClient->oauthClient->id;
        $oauthUser->userId = $this->user->id;
        $oauthUser->externalId = strval($this->user->id);

        $saveOAuthUser = OAuthUserEntitySaveDAO::make($this->factory());
        $saveOAuthUser->entity = $oauthUser;
        $saveOAuthUser->serve();
    }

    public function apply(object $object): void
    {
        if ($object instanceof UserRegistrationEvent) {
            $this->user = $object->user;
        }
    }

}
