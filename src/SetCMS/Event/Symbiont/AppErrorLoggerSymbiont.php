<?php

declare(strict_types=1);

namespace SetCMS\Event\Symbiont;

use SetCMS\Event\AppErrorEvent;
use SetCMS\Logger\Servant\LoggerServant;

class AppErrorLoggerSymbiont extends \UUA\SymbiontCustomizer
{

    #[\Override]
    public function from(object $object): void
    {
        if ($object instanceof AppErrorEvent) {
            $master = LoggerServant::as($this->master);
            $master->message = $object->message;
            $master->context = $object->context;
            $master->loggerChannel = 'app';
            $master->loggerLevel = 'critical';
        }
    }
}
