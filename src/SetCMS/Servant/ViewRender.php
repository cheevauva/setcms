<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\Servant\ViewHtmlRender;
use SetCMS\Contract\Twigable;
use SetCMS\View\Scope\ViewJsonExceptionScope;
use SetCMS\View\Scope\ViewHtmlExceptionScope;

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
            if ($object instanceof Twigable) {
                $this->makeBodyAsHtml($object);
            } else {
                $this->makeBodyAsJson($object);
            }
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

    protected function makeBodyAsHtml(object $object): void
    {
        $htmlRender = ViewHtmlRender::make($this->factory());
        $htmlRender->request = $this->request;
        $htmlRender->mixedValue = $object;
        $htmlRender->serve();

        $this->contentType = 'text/html';
        $this->content = $htmlRender->html;
    }

    protected function makeBodyAsJson(Scope $object): void
    {
        $jsonRender = ViewJsonRender::make($this->factory());
        $jsonRender->request = $this->request;
        $jsonRender->mixedValue = $object;
        $jsonRender->serve();

        $this->contentType = 'application/json';
        $this->content = $jsonRender->json;
    }

}
