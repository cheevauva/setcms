<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Scope;
use Psr\Http\Message\ServerRequestInterface;

class ViewJsonRender implements Servant
{
    use \SetCMS\QuickTrait;

    public object $mixedValue;
    public ?string $json = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Scope) {
            $this->json = json_encode([
                'result' => !$object->messages,
                'data' => $object->toArray(),
                'messages' => $object->messages,
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return;
        }

        $this->json = json_encode([
            'result' => true,
            'data' => $object,
            'messages' => [],
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

}
