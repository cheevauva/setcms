<?php

$events = [
    SetCMS\Controller\Event\ControllerOnBeforeServeEvent::class => [
        [Module\ACL\Servant\ACLCheckByRoleAndPrivilegeServant::class, \Module\ACL\Symbiont\ACLUserScopeProtectionSymbiont::class],
    ],
    \SetCMS\Event\AppErrorEvent::class => [
        [\SetCMS\Logger\Servant\LoggerServant::class, \SetCMS\Logger\Symbiont\LoggerAppErrorSymbiont::class],
    ]
];

foreach (glob(__DIR__ . '/events/*') ?: [] as $file) {
    require $file;
}

return $events;
