<?php

declare(strict_types=1);

namespace SetCMS\Logger\Servant;

class LoggerServant extends \UUA\Servant
{

    public string $loggerChannel;
    public string $loggerLevel;
    public string $message;
    public array $context = [];

    #[\Override]
    public function serve(): void
    {
        $msg = sprintf('%s [%s]: %s %s', date('Y-m-d H:i:s'), getmypid(), $this->message, json_encode($this->context, JSON_UNESCAPED_UNICODE));
        error_log($msg, 0);
    }
}
