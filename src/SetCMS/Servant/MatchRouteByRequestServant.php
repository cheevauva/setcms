<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Contract\Router;
use SetCMS\Router\RouterMatchDTO;

class MatchRouteByRequestServant implements Servant, Applicable
{

    use \SetCMS\FactoryTrait;
    use \SetCMS\DITrait;

    private Router $router;
    public string $path;
    public ?string $scriptName = null;
    public string $requestMethod = 'GET';
    public ?RouterMatchDTO $routerMatch = null;

    public function serve(): void
    {
        $this->router = $this->container->get(Router::class);
        $this->routerMatch = $this->router->match($this->path, $this->requestMethod);
    }

    public function apply(object $object): void
    {
        if ($object instanceof ServerRequestInterface) {
            $this->path = $object->getUri()->getPath();
            $this->requestMethod = $object->getMethod();
        }
    }

}
