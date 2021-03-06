<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\ServantInterface;
use Psr\Http\Message\ServerRequestInterface;

class ParseBodyRequestServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    public ServerRequestInterface $request;

    public function serve(): void
    {
        $content = $this->request->getBody()->getContents();

        if (strpos($this->request->getHeaderLine('Content-type'), 'application/json') !== false && $content) {
            $this->request = $this->request->withParsedBody(json_decode($content, true));
        }
    }

}
