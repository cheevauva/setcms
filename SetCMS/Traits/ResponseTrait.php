<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;

trait ResponseTrait
{

    protected function newResponse(): ResponseInterface
    {
        return new Response();
    }
}
