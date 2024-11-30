<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Controller\Hook\ParseBodyHook;

class ParseBodyRequestServant implements Servant, Applicable
{

    use \SetCMS\Traits\FactoryTrait;

    public ServerRequestInterface $request;
    public mixed $parsedBody = null;

    public function serve(): void
    {
        $contentType = $this->request->getHeaderLine('Content-type') ?? '';
        $content = $this->request->getBody()->getContents();

        if (str_contains($contentType, 'application/json') && $content) {
            $this->parsedBody = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof ParseBodyHook) {
            $this->request = $object->request;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof ParseBodyHook) {
            $object->withParsedBody($this->parsedBody);
        }
    }

}
