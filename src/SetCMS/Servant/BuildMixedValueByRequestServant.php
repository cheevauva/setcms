<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Core\ServantInterface;
use SetCMS\TargetForm;

class BuildMixedValueByRequestServant implements ServantInterface
{

    private ContainerInterface $container;
    public ServerRequestInterface $request;
    public ?ResponseInterface $response = null;
    public object $mixedValue;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function serve(): void
    {
        $matchRequest = new MatchRouteByRequestServant($this->container);
        $matchRequest->apply($this->request);
        $matchRequest->serve();

        foreach ($matchRequest->result as $attribute => $attributeValue) {
            $this->request = $this->request->withAttribute($attribute, $attributeValue);
        }

        $targetForm = new TargetForm;
        $targetForm->fromArray($matchRequest->result);

        if (!$targetForm->valid()) {
            throw new \RuntimeException('invalid route');
        }
        
        $controllerWithMethod = new BuildControllerWithReflectionMethodServant;
        $controllerWithMethod->apply($targetForm);
        $controllerWithMethod->serve();

        $methodArguments = new RetrieveArgumentsByReflectionMethodServant($this->container);
        $methodArguments->method = $controllerWithMethod->method;
        $methodArguments->apply($this->request);
        $methodArguments->apply($this->response ?? $this->container->get(ResponseInterface::class));
        $methodArguments->serve();

        $this->mixedValue = $controllerWithMethod->method->invokeArgs($controllerWithMethod->controller, $methodArguments->arguments);
    }

}
