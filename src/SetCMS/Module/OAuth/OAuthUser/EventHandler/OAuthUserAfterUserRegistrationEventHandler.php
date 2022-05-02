<?php

namespace SetCMS\Module\OAuth\OAuthUser\EventHandler;

use SetCMS\FactoryInterface;
use SetCMS\Module\User\Event\UserAfterRegistrationEvent;
use SetCMS\Module\OAuth\OAuthUser\Servant\OAuthUserCreateByUserServant;

class OAuthUserAfterRegistrationUserEventHandler
{

    private OAuthUserCreateByUserServant $createOauthUser;

    public function __construct(FactoryInterface $factory)
    {
        $this->createOauthUser = $factory->make(OAuthUserCreateByUserServant::class);
    }

    public function __invoke(UserAfterRegistrationEvent $event): UserAfterRegistrationEvent
    {
        $this->createOauthUser->user = $event->user;
        $this->createOauthUser->serve();

        return $event;
    }

}
