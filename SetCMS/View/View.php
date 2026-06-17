<?php

declare(strict_types=1);

namespace SetCMS\View;

use SplObjectStorage;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class View extends \UUA\View implements \SetCMS\Contract\ContractObjectInteraction
{

    /**
     * @var SplObjectStorage<object, mixed>
     */
    public SplObjectStorage $messages;
    public ServerRequestInterface $request;
    public protected(set) ?ResponseInterface $response = null;

    #[\Override]
    public function from(object $object): void
    {
        
    }

    #[\Override]
    public function to(object $object): void
    {
        
    }
}
