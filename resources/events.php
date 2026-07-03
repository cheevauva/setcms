<?php

$events = [
    \SetCMS\Event\AppErrorEvent::class => [
        \SetCMS\UseCase\Logger\Servant\LoggerServant::class,
    ]
];

foreach (glob(__DIR__ . '/events/*') ?: [] as $file) {
    require $file;
}

return $events;
