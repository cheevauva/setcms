<?php

declare(strict_types=1);

namespace SetCMS\Controller\Hook;

use Psr\Http\Message\ServerRequestInterface;

class ParseBodyHook
{

    use \SetCMS\HookTrait;

    public function __construct(public ServerRequestInterface $request)
    {
        
    }

    public function withParsedBody(mixed $data)
    {
        $this->request = $this->request->withParsedBody($data);
    }

}
