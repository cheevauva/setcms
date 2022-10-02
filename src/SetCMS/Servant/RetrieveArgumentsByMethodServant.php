<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\ServantInterface;
use SetCMS\Contract\Applicable;
use SetCMS\FactoryInterface;

class RetrieveArgumentsByMethodServant implements ServantInterface, Applicable
{

    use \SetCMS\FactoryTrait;

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

            if (!$parameter->getType()) {
                $this->arguments[$parameter->getPosition()] = null;
                continue;
            }

            $type = $parameter->getType()->getName();

            switch ($parameter->getType()->getName()) {
                case ServerRequestInterface::class:
                    $value = $this->request ?? $this->container->get(ServerRequestInterface::class);
                    break;
                case ResponseInterface::class;
                    $value = $this->response ?? $this->container->get(ResponseInterface::class);
                    break;
                case FactoryInterface::class:
                    $value = $this->container->get(FactoryInterface::class);
                    break;
                case ContainerInterface::class:
                    $value = $this->container;
                    break;
                default:
                    $value = $this->container->make($type);
                    break;
            }

            $this->arguments[$parameter->getPosition()] = $value;
        }
    }

    public function apply(object $object): void
    {

        if ($object instanceof \ReflectionMethod) {
            $this->method = $object;
        }
        if ($object instanceof ServerRequestInterface) {
            $this->request = $object;
        }

        if ($object instanceof ResponseInterface) {
            $this->response = $object;
        }

        if ($object instanceof \SplObjectStorage) {
            foreach ($object as $item) {
                $this->apply($item);
            }
        }
    }

}
