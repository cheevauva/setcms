<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\View\Scope\ViewJsonExceptionScope;
use SetCMS\View\Scope\ViewHtmlExceptionScope;
use SetCMS\View\Hook\ViewRenderHook;

class ViewRender implements Servant
{

    use \SetCMS\FactoryTrait;
    use \SetCMS\DITrait;

    public ?object $mixedValue = null;
    public ServerRequestInterface $request;
    public string $content;
    public string $contentType;

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof \Throwable) {
            $object = $this->makeScopeByThrowable($object);
        }

        if ($object instanceof Scope) {
            $hook = new ViewRenderHook;
            $hook->data = $object;
            $hook->request = $this->request;
            $hook->dispatch();

            $this->content = $hook->content ?? '';
            $this->contentType = $hook->contentType ?? '';
        }
    }

    protected function makeScopeByThrowable(\Throwable $object): Scope
    {
        $acceptType = $this->request->getHeaderLine('Accept') ?? 'application/json';

        if (str_contains($acceptType, 'application/json')) {
            $scope = new ViewJsonExceptionScope;
            $scope->from($object);
        }

        if (str_contains($acceptType, 'text/html')) {
            $scope = new ViewHtmlExceptionScope;
            $scope->from($object);
        }

        return $scope;
    }

}
