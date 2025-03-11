<?php

declare(strict_types=1);

namespace SetCMS\Event;

class AppErrorEvent
{

    use \UUA\Traits\EventTrait;

    public function __construct(public string $message, public array $context = [])
    {
        
    }
}
