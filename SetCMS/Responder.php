<?php

declare(strict_types=1);

namespace SetCMS;

use SplObjectStorage;
use Psr\Http\Message\ResponseInterface;

abstract class Responder extends \UUA\Responder
{

    /**
     * @var array<string|object>
     */
    public array $ctx;

    /**
     * @var SplObjectStorage<object, mixed>
     */
    public SplObjectStorage $messages;
    public protected(set) ?ResponseInterface $response = null;
}
