<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\Servant;

use SetCMS\Module\User\UserEntity;
use SetCMS\Module\OAuth\OAuthUser\OAuthUserEntity;
use SetCMS\Module\OAuth\OAuthUser\DAO\OAuthUserEntityDbSaveDAO;

class OAuthUserCreateByUserServant implements \SetCMS\ServantInterface
{

    use \SetCMS\FactoryTrait;

    private OAuthUserEntityDbSaveDAO $save;
    public UserEntity $user;

    public function serve(): void
    {
        $oauthUser = new OAuthUserEntity;
        $oauthUser->clientId = 1;
        $oauthUser->userId = $this->user->id;
        $oauthUser->externalId = $this->user->id;

        $this->save->entity = $oauthUser;
        $this->save->serve();
    }

}
