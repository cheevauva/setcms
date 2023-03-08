<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Contract\Factory;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Scope;
use SetCMS\Contract\Servant;
use SetCMS\Servant\BuildResponseByExceptionServant;
use SetCMS\Servant\BuildHtmlContentByMixedValue;
use SetCMS\Contract\Twigable;

class BuildResponseByMixedValueServant implements Servant
{

    use \SetCMS\FactoryTrait;

    private Factory $factory;
    public ?object $mixedValue = null;
    public ServerRequestInterface $request;
    public ResponseInterface $response;

    public function __construct(Factory $container)
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
                $buildHtmlContent = BuildHtmlContentByMixedValue::make($this->factory);
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
            $builderResponseByException = BuildResponseByExceptionServant::make($this->factory);
            $builderResponseByException->exception = $object;
            $builderResponseByException->request = $this->request;
            $builderResponseByException->serve();
            $this->response = $builderResponseByException->response;
        }
    }

}
