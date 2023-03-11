<?php

declare(strict_types=1);

namespace SetCMS\Controller\Event;

use Psr\Http\Message\ServerRequestInterface;

class ParseBodyEvent
{

    use \SetCMS\EventTrait;

    public function __construct(public ServerRequestInterface $request)
    {
        
    }

    public function withParsedBody(mixed $data)
    {
        $this->request = $this->request->withParsedBody($data);
    }

}
