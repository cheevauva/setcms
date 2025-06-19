<?php

declare(strict_types=1);

namespace SetCMS\Event;

class AppErrorEvent
{

    use \UUA\Traits\EventTrait;

    /**
     * @param string $message
     * @param mixed[] $context
     */
    public function __construct(public string $message, public array $context = [])
    {
        
    }
}
