<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\FactoryInterface;
use SetCMS\Core\ServantInterface;
use SetCMS\Core\ApplyInterface;
use SetCMS\Router\RouterInterface;
use SetCMS\Router\RouterException;
use SetCMS\Router\RouterMatchDTO;

class MatchRouteByRequestServant implements ServantInterface, ApplyInterface
{

    use \SetCMS\FactoryTrait;

    private RouterInterface $router;
    public string $requestUri;
    public ?string $scriptName = null;
    public string $requestMethod = 'GET';
    public ?RouterMatchDTO $routerMatch = null;

    public function __construct(FactoryInterface $factory)
    {
        $this->router = $factory->make(RouterInterface::class);
    }

    public function serve(): void
    {
        $requestUri = $this->requestUri;
        $scriptName = $this->scriptName;

        if ($requestUri === $scriptName) {
            $requestUri .= '/';
        }

        if ($requestUri . 'index.php' === $scriptName) {
            $requestUri = '/';
        }

        if (strpos($requestUri, 'index.php') !== false) {
            $this->router->setBasePath($scriptName);
        }


        $result = $this->router->match($requestUri, $this->requestMethod) ?: null;

        if (!$result) {
            throw RouterException::notFound();
        }

        $routerMatch = new RouterMatchDTO;
        $routerMatch->params = $result['params'];
        $routerMatch->target = $result['target'];
        $routerMatch->name = $result['name'];
        
        $this->routerMatch = $routerMatch;
        
    }

    public function apply(object $object): void
    {
        if ($object instanceof ServerRequestInterface) {
            $this->requestUri = $object->getServerParams()['REQUEST_URI'];
            $this->scriptName = $object->getServerParams()['SCRIPT_NAME'];
            $this->requestMethod = $object->getServerParams()['REQUEST_METHOD'];
        }
    }

}
