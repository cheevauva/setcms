<?php

declare(strict_types=1);

namespace SetCMS;

use SplObjectStorage;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Responder extends \UUA\Responder
{

    /**
     * @var SplObjectStorage<object, mixed>
     */
    public SplObjectStorage $messages;
    public ServerRequestInterface $request;
    public protected(set) ?ResponseInterface $response = null;
}
