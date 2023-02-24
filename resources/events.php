<?php

return [
    SetCMS\Module\User\Event\UserRegistrationEvent::class => [
    ],
    \SetCMS\Controller\Event\ScopeProtectionEvent::class => [
        \SetCMS\Module\User\Servant\UserProtectScopeServant::class,
    ],
    \SetCMS\Controller\Event\FrontControllerResolveEvent::class => [
        \SetCMS\Module\User\Servant\UserGuestServant::class,
        \SetCMS\Module\Session\Servant\SessionRetrieveUserServant::class,
    ],
];
