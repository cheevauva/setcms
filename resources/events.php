<?php

$events = [
    SetCMS\Controller\Hook\ParseBodyHook::class => [
        [SetCMS\Servant\ParseBodyRequestServant::class],
    ],
    SetCMS\Module\User\Event\UserRegistrationEvent::class => [
    ],
    SetCMS\Controller\Hook\ScopeProtectionHook::class => [
        [SetCMS\Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant::class, \SetCMS\Module\ACL\EventHandler\ACLUserScopeProtectionEventHandler::class],
    ],
    \SetCMS\Controller\Hook\FrontControllerResolveHook::class => [
        [\SetCMS\Module\User\Servant\UserGuestServant::class],
        [\SetCMS\Module\UserSession\Servant\UserSessionRetrieveUserServant::class],
    ],
    SetCMS\View\Hook\ViewRenderHook::class => [
        [\SetCMS\Servant\ViewCompositeRender::class, \SetCMS\EventHandler\ViewRenderEventHandler::class],
        [\SetCMS\Servant\ViewTwigRender::class, \SetCMS\EventHandler\ViewRenderEventHandler::class],
        [\SetCMS\Servant\ViewJsonRender::class, \SetCMS\EventHandler\ViewRenderEventHandler::class],
    ]
];

foreach (glob(__DIR__ . '/hooks/*') as $file) {
    require $file;
}

return $events;
