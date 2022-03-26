<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use SetCMS\Core\ServantInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Router;

class MatchRequestRouterServant implements ServantInterface
{

    private Router $router;
    public ServerRequestInterface $request;
    public ?array $result = null;

    public function __construct(ContainerInterface $container)
    {
        $this->router = $container->get(Router::class);
    }

    public function serve(): void
    {
        $requestUri = $this->request->getServerParams()['REQUEST_URI'];
        $scriptName = $this->request->getServerParams()['SCRIPT_NAME'];

        if ($requestUri === $scriptName) {
            $requestUri .= '/';
        }

        if ($requestUri . 'index.php' === $scriptName) {
            $requestUri = '/';
        }

        if (strpos($requestUri, 'index.php') !== false) {
            $this->router->setBasePath($scriptName);
        }


        $result = $this->router->match($requestUri, $this->request->getServerParams()['REQUEST_METHOD']) ?: null;

        if (!$result) {
            throw new \Exception('not match');
        }

        $this->result = array_merge($result['params'], $result['target']);
    }

}
