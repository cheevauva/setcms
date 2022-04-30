<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\FactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Core\Form;
use SetCMS\ServantInterface;
use SetCMS\Servant\BuildResponseByExceptionServant;

class BuildResponseByMixedValueServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    public ?object $mixedValue = null;
    public ServerRequestInterface $request;
    public ResponseInterface $response;

    public function __construct(FactoryInterface $container)
    {
        $this->factory = $container;
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

        if ($object instanceof \Throwable) {
            $builderResponseByException = BuildResponseByExceptionServant::factory($this->factory);
            $builderResponseByException->exception = $object;
            $builderResponseByException->request = $this->request;
            $builderResponseByException->serve();
            $this->response = $builderResponseByException->response;
        }
    }

}
