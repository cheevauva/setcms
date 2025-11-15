<?php

$events = [
    SetCMS\Controller\Event\ControllerOnBeforeServeEvent::class => [
        [SetCMS\ACL\Servant\ACLCheckByRoleAndPrivilegeServant::class, \SetCMS\ACL\Symbiont\ACLUserScopeProtectionSymbiont::class],
    ],
    \SetCMS\Event\AppErrorEvent::class => [
        [\SetCMS\Logger\Servant\LoggerServant::class, \SetCMS\Logger\Symbiont\LoggerAppErrorSymbiont::class],
    ]
];

foreach (glob(__DIR__ . '/events/*') ?: [] as $file) {
    require $file;
}

return $events;
