<?php

$events = [
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
    SetCMS\View\Hook\ViewRenderHook::class => [
        \SetCMS\Servant\ViewHtmlRender::class,
        \SetCMS\Servant\ViewJsonRender::class,
    ]
];

foreach (glob(__DIR__ . '/hooks/*') as $file) {
    require $file;
}

return $events;
