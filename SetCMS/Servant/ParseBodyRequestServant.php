<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;

class ParseBodyRequestServant extends \UUA\Servant
{

    public ServerRequestInterface $request;
    public mixed $parsedBody = null;

    public function serve(): void
    {
        $contentType = $this->request->getHeaderLine('Content-type');
        $content = $this->request->getBody()->getContents();

        if (str_contains($contentType, 'application/json') && $content) {
            $this->parsedBody = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        }
    }
}
