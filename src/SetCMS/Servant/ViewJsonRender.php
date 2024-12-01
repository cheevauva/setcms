<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Application\Contract\ContractApplicable;
use SetCMS\Scope;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View\Hook\ViewRenderHook;

class ViewJsonRender implements ContractServant, ContractApplicable
{

    use \SetCMS\Traits\QuickTrait;

    public object $mixedValue;
    public ?string $json = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Scope) {
            $this->json = json_encode([
                'result' => !$object->hasMessages(),
                'data' => $object->toArray(),
                'messages' => $object->getMessages(),
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            return;
        }

        $this->json = json_encode([
            'result' => true,
            'data' => $object,
            'messages' => [],
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function from(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            $this->mixedValue = $object->data;
            $this->request = $object->request;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            $object->content = $this->json;
            $object->contentType = 'application/json';
        }
    }

}
