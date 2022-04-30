<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Core\ServantInterface;


class BuildMixedValueByRequestServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;
    private MatchRouteByRequestServant $matchRequest;
    public ServerRequestInterface $request;
    public ?ResponseInterface $response = null;
    public object $mixedValue;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
        $this->matchRequest = MatchRouteByRequestServant::factory($this->factory);
    }

    public function serve(): void
    {
        $methodArguments = new RetrieveArgumentsByMethodServant($this->container);
        $methodArguments->method = $controllerWithMethod->method;
        $methodArguments->apply($this->request);
        $methodArguments->apply($this->response ?? $this->container->get(ResponseInterface::class));
        $methodArguments->serve();

        $this->mixedValue = $controllerWithMethod->method->invokeArgs($controllerWithMethod->controller, $methodArguments->arguments);
    }

}
