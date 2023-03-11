<?php

return [
    SetCMS\Controller\Hook\ParseBodyHook::class => [
        SetCMS\Servant\ParseBodyRequestServant::class,
    ],
    SetCMS\Module\User\Event\UserRegistrationEvent::class => [
    ],
    SetCMS\Controller\Hook\ScopeProtectionHook::class => [
        \SetCMS\Module\User\Servant\UserProtectScopeServant::class,
    ],
    \SetCMS\Controller\Hook\FrontControllerResolveHook::class => [
        \SetCMS\Module\User\Servant\UserGuestServant::class,
        \SetCMS\Module\UserSession\Servant\UserSessionRetrieveUserServant::class,
    ],
];
