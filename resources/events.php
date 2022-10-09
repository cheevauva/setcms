<?php

return [
    SetCMS\Module\User\Event\UserRegistrationEvent::class => [
        SetCMS\Module\OAuth\OAuthUser\Servant\OAuthUserCreateByUserServant::class,
    ],
    \SetCMS\Controller\Event\ScopeProtectionEvent::class => [
        \SetCMS\Module\User\Servant\UserProtectScopeServant::class,
    ],
    \SetCMS\Controller\Event\FrontControllerResolveEvent::class => [
        \SetCMS\Module\OAuth\Servant\OAuthRetrieveCurrentUserByOAuthTokenServant::class,
    ],
];
