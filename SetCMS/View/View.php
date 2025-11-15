<?php

declare(strict_types=1);

namespace SetCMS\View;

use SplObjectStorage;
use Psr\Http\Message\ResponseInterface;

abstract class View extends \UUA\View
{

    /**
     * @var array<string, mixed|object>
     */
    public array $ctx;

    /**
     * @var SplObjectStorage<object, mixed>
     */
    public SplObjectStorage $messages;
    public protected(set) ResponseInterface $response;
}
