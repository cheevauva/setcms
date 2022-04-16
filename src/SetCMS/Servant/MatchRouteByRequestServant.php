<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Core\ServantInterface;
use SetCMS\Core\ApplyInterface;
use SetCMS\Router;
use SetCMS\Exception\RouteNotFound;

class MatchRouteByRequestServant implements ServantInterface, ApplyInterface
{

    private Router $router;
    public string $requestUri;
    public ?string $scriptName = null;
    public string $requestMethod = 'GET';
    public ?array $result = null;

    public function __construct(ContainerInterface $container)
    {
        $this->router = $container->get(Router::class);
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
            throw new RouteNotFound;
        }

        $this->result = array_merge($result['params'], $result['target']);
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
