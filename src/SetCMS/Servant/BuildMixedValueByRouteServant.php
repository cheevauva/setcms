<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use SetCMS\Core\ServantInterface;
use SetCMS\FrontController\TargetForm;

class BuildMixedValueByRouteServant implements ServantInterface
{

    private ContainerInterface $container;
    public string $route;
    public array $params = [];
    public object $mixedValue;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function serve(): void
    {
        $matchRequest = new MatchRouteByRequestServant($this->container);
        $matchRequest->requestUri = $this->route;
        $matchRequest->serve();

        $targetForm = new TargetForm;
        $targetForm->fromArray($matchRequest->routerMatch);

        $controllerWithMethod = new BuildControllerWithReflectionMethodServant;
        $controllerWithMethod->apply($targetForm);
        $controllerWithMethod->serve();

        $methodArguments = new RetrieveArgumentsByReflectionMethodServant($this->container);
        $methodArguments->method = $controllerWithMethod->method;
        $methodArguments->serve();

        foreach ($methodArguments->arguments as $arg) {
            if ($arg instanceof Form) {
                $arg->fromArray($this->params);
            }
        }

        $this->mixedValue = $controllerWithMethod->method->invokeArgs($controllerWithMethod->controller, $methodArguments->arguments);
    }

}
