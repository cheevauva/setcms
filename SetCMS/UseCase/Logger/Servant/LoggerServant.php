<?php

declare(strict_types=1);

namespace SetCMS\UseCase\Logger\Servant;

use SetCMS\Event\AppErrorEvent;

class LoggerServant extends \UUA\Servant
{

    public string $loggerChannel;
    public string $loggerLevel;
    public string $message;

    /**
     * @var array<int|string, mixed>
     */
    public array $context = [];

    #[\Override]
    public function serve(): void
    {
        $msg = sprintf('%s [%s]: %s %s', date('Y-m-d H:i:s'), getmypid(), $this->message, json_encode($this->context, JSON_UNESCAPED_UNICODE));
        error_log($msg, 0);
    }

    public function __invoke(object $object): void
    {
        if ($object instanceof AppErrorEvent) {
            $this->message = $object->message;
            $this->context = $object->context;
            $this->loggerChannel = 'app';
            $this->loggerLevel = 'critical';
        }
    }
}
