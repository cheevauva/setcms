<?php

namespace SetCMS\Module\OAuth\OAuthUserEventHandler;

use SetCMS\Module\OAuth\OAuthUserDAO;
use SetCMS\Module\OAuth\OAuthUser;
use SetCMS\Module\Users\UserEvent\RegistrationUserEvent;

class RegistrationUserEventHandler
{

    private OAuthUserDAO $oauthUserDAO;

    public function __construct(OAuthUserDAO $oauthUserDAO)
    {
        $this->oauthUserDAO = $oauthUserDAO;
    }

    public function __invoke(RegistrationUserEvent $event): RegistrationUserEvent
    {
        $oauthUser = new OAuthUser;
        $oauthUser->clientId = 1;
        $oauthUser->userId = $event->user->id;
        $oauthUser->externalId = $event->user->id;
        $oauthUser->refreshToken = md5(microtime());

        $this->oauthUserDAO->save($oauthUser);

        return $event;
    }

}
