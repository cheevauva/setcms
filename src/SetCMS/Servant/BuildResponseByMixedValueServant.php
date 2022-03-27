<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Throwable;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Core\Form;
use SetCMS\Core\ServantInterface;

class BuildResponseByMixedValueServant implements ServantInterface
{

    private ContainerInterface $container;
    public object $mixedValue;
    public ServerRequestInterface $request;
    public ResponseInterface $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function serve(): void
    {
        $object = $this->mixedValue;
        $this->response = new Response;

        if ($object instanceof Form) {
            $this->response = $this->response->withHeader('Content-type', 'application/json');
            $this->response->getBody()->write(json_encode($object->toArray(), JSON_UNESCAPED_UNICODE));
        }

        if ($object instanceof ResponseInterface) {
            $this->response = $object;
        }

        if ($object instanceof Throwable) {
            $builderResponseByException = new BuildResponseByExceptionServant($this->container);
            $builderResponseByException->exception = $object;
            $builderResponseByException->request = $this->request;
            $builderResponseByException->serve();
            $this->response = $builderResponseByException->response;
        }
    }

}
