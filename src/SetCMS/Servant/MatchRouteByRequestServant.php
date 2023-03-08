<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Contract\Factory;
use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Contract\Router;
use SetCMS\Router\RouterMatchDTO;

class MatchRouteByRequestServant implements Servant, Applicable
{

    use \SetCMS\FactoryTrait;

    private Router $router;
    public string $requestUri;
    public ?string $scriptName = null;
    public string $requestMethod = 'GET';
    public ?RouterMatchDTO $routerMatch = null;

    public function __construct(Factory $factory)
    {
        $this->router = $factory->make(Router::class);
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

        if (str_contains($requestUri, 'index.php')) {
            $this->router->setBasePath($scriptName);
        }

        $this->routerMatch = $this->router->match($requestUri, $this->requestMethod);
        
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
