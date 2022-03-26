<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Core\Form;
use SetCMS\Core\ServantInterface;
use Throwable;

class PrepareResponseByMixedValueServant implements ServantInterface
{

    public object $mixedValue;
    public ResponseInterface $response;

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Form) {
            $this->response = (new Response)->withHeader('Content-type', 'application/json');
            $this->response->getBody()->write(json_encode($object->toArray(), JSON_UNESCAPED_UNICODE));
        }

        if ($object instanceof ResponseInterface) {
            $this->response = $object;
        }

        if ($object instanceof Throwable) {
            $this->response = (new Response)->withHeader('Content-type', 'application/json');
            $this->response->getBody()->write(json_encode([$object->getMessage(), $object->getTrace()], JSON_UNESCAPED_UNICODE));
        }
    }

}
