<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Core\ServantInterface;
use SetCMS\Core\ApplyInterface;

class RetrieveArgumentsByReflectionMethodServant implements ServantInterface, ApplyInterface
{

    private ContainerInterface $container;
    private ?ServerRequestInterface $request = null;
    private ?ResponseInterface $response = null;
    public \ReflectionMethod $method;
    public array $arguments;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function serve(): void
    {
        $this->arguments = [];

        foreach ($this->method->getParameters() as $parameter) {
            assert($parameter instanceof \ReflectionParameter);

            $type = $parameter->getType()->getName();

            switch ($parameter->getType()->getName()) {
                case ServerRequestInterface::class:
                    $value = $this->request ?? $this->container->get(ServerRequestInterface::class);
                    break;
                case ResponseInterface::class;
                    $value = $this->response ?? $this->container->get(ResponseInterface::class);
                    break;
                default:
                    $value = $this->container->get($type);
                    break;
            }

            $this->arguments[$parameter->getPosition()] = $value;
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }

        if ($object instanceof ResponseInterface) {
            $this->response = $object;
        }
    }

}
