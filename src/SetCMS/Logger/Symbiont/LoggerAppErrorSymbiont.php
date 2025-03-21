<?php

declare(strict_types=1);

namespace SetCMS\Logger\Symbiont;

use SetCMS\Event\AppErrorEvent;
use SetCMS\Logger\Servant\LoggerServant;

class LoggerAppErrorSymbiont extends \UUA\SymbiontCustomizer
{

    #[\Override]
    public function to(object $object): void
    {
        $master = AppErrorEvent::as($this->master);

        if ($object instanceof LoggerServant) {
            $object->message = $master->message;
            $object->context = $master->context;
            $object->loggerChannel = 'app';
            $object->loggerLevel = 'critical';
        }
    }
}
