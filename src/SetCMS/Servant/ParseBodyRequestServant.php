<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Core\ServantInterface;
use Psr\Http\Message\ServerRequestInterface;

class ParseBodyRequestServant implements ServantInterface
{

    public ServerRequestInterface $request;

    public function serve(): void
    {
        $content = $this->request->getBody()->getContents();

        if (strpos($this->request->getHeaderLine('Accept'), 'application/json') !== false && $content) {
            $this->request = $this->request->withParsedBody(json_decode($content, true));
        }
    }

}
