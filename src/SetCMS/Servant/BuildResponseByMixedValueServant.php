<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\FactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Scope;
use SetCMS\ServantInterface;
use SetCMS\Servant\BuildResponseByExceptionServant;
use SetCMS\Servant\BuildHtmlContentByMixedValue;
use SetCMS\Contract\Twigable;

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

        if (is_null($object)) {
            $this->response->getBody()->write('Success!');
        }

        if ($object instanceof Scope) {
            $twig = $object;
            if ($twig instanceof Twigable) {
                $buildHtmlContent = BuildHtmlContentByMixedValue::factory($this->factory);
                $buildHtmlContent->request = $this->request;
                $buildHtmlContent->mixedValue = $object;
                $buildHtmlContent->serve();
                $this->response->getBody()->write($buildHtmlContent->htmlContent);
            } else {
                $this->response = $this->response->withHeader('Content-type', 'application/json');
                $this->response->getBody()->write(json_encode([
                    'result' => !$object->messages,
                    'data' => $object->toArray(),
                    'messages' => $object->messages,
                ], JSON_UNESCAPED_UNICODE));
            }
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
