<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Application\Contract\ContractApplicable;
use SetCMS\Application\Contract\ContractRouterInterface;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\Uri;
use SetCMS\Scope;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View\Hook\ViewRenderHook;
use SetCMS\Module\Dynamic\DAO\DynamicMethodRetrieveByServerRequestDAO;

class ViewCompositeRender implements ContractServant, ContractApplicable
{

    use \SetCMS\Traits\QuickTrait;

    public object $mixedValue;
    public ?string $content = null;
    public ?string $contentType = null;
    public ServerRequestInterface $request;
    public string $context;

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Scope) {
            $scope = $object;
            $call = fn(string $path, array $params = []): mixed => $this->scCall($path, $params);
            $content = null;
            $contentType = null;
            $file = sprintf('%s/resources/composite/%s.php', $this->container->get('basePath'), $this->templateNameByScope($object));

            if (file_exists($file)) {
                require $file;
            }

            $this->content = $content;
            $this->contentType = $contentType;
        }
    }

    private function templateNameByScope(Scope $scope): string
    {
        $templateName = (new \ReflectionObject($scope))->getShortName();

        return $templateName;
    }

    protected function createRequestByPath(string $path, array $params = []): ServerRequestInterface
    {
        $request = (new ServerRequestFactory)->createServerRequest('GET', new Uri($path));
        $request = $request->withAttribute('currentUser', $this->request->getAttribute('currentUser'));
        $request = $request->withAttribute('parentRequest', $this->request);
        $request = $request->withQueryParams($params);

        return $request;
    }

    protected function scCall(string $path, array $params = []): mixed
    {
        $routerMatch = $this->router()->match($path, 'GET');

        $request = $this->createRequestByPath($path, $params);
        $request = $request->withAttribute('routeTarget', $routerMatch->target);

        foreach ($routerMatch->params as $pName => $pValue) {
            $request = $request->withAttribute($pName, $pValue);
        }

        $retrieveByPath = DynamicMethodRetrieveByServerRequestDAO::make($this->factory());
        $retrieveByPath->request = $request;
        $retrieveByPath->serve();

        foreach ($retrieveByPath->reflectionArguments as $argument) {
            if ($argument instanceof Scope) {
                $argument->from($request);
            }
        }

        return $retrieveByPath->reflectionMethod->invokeArgs($retrieveByPath->reflectionObject, $retrieveByPath->reflectionArguments);
    }

    protected function router(): ContractRouterInterface
    {
        return $this->container->get(ContractRouterInterface::class);
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
            $object->content = $this->content;
            $object->contentType = $this->contentType;
        }
    }
}
