<?php

declare(strict_types=1);

$events[\SetCMS\Controller\Event\ControllerOnBeforeServeEvent::class] = [
    \Module\ACL\Servant\ACLControllerServant::class,
];
