<?php

return [
    SetCMS\Module\User\Event\UserAfterRegistrationEvent::class => [
        SetCMS\Module\OAuth\OAuthUser\Servant\OAuthUserCreateByUserServant::class,
    ],
    \SetCMS\Controller\Event\ScopeProtectionEvent::class => [
        \SetCMS\Module\User\Servant\UserProtectScopeServant::class,
    ],
    \SetCMS\Event\FrontControllerBeforeLaunchActionEvent::class => [
        \SetCMS\Module\OAuth\Event\RetrieveCurrentUserByOAuthTokenServant::class,
    ],
];
