<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use SetCMS\Servant\BuildHtmlContentByMixedValue;
use SetCMS\Core\ServantInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use Throwable;
use SetCMS\Throwable\NotFound;

class BuildResponseByExceptionServant implements ServantInterface
{

    use \SetCMS\FactoryTrait;

    private ContainerInterface $container;
    public ServerRequestInterface $request;
    public ResponseInterface $response;
    public Throwable $exception;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function serve(): void
    {
        $this->response = new Response;

        if ($this->exception instanceof NotFound) {
            $this->response = $this->response->withStatus(404);
        }

        if ($this->response->getStatusCode() === 200) {
            $this->response = $this->response->withStatus(500);
        }

        $accept = $this->request->getHeaderLine('Accept');

        if (strpos($accept, 'application/json') !== false) {
            $this->response = $this->response->withHeader('Content-type', 'application/json');
            $this->response->getBody()->write(json_encode([
                'success' => false,
                'messages' => [
                    $this->exception->getMessage(),
                ],
                'result' => null,
            ], JSON_UNESCAPED_UNICODE));
        }

        if (strpos($accept, 'text/html') !== false) {
            $buildHtmlContent = new BuildHtmlContentByMixedValue($this->container);
            $buildHtmlContent->mixedValue = $this->exception;
            $buildHtmlContent->serve();
            $this->response->getBody()->write($buildHtmlContent->htmlContent);
        }
    }

}
