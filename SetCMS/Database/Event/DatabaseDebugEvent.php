<?php

declare(strict_types=1);

namespace SetCMS\Database\Event;

class DatabaseDebugEvent
{

    /**
     * 
     * @param string $message
     * @param array<mixed, mixed> $ctx
     */
    public function __construct(public string $message, public array $ctx)
    {
        
    }

    use \SetCMS\Traits\EventTrait;
}
