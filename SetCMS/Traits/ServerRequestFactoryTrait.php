<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestFactoryInterface;

trait ServerRequestFactoryTrait
{

    protected function serverRequestFactory(): ServerRequestFactoryInterface
    {
        return new ServerRequestFactory();
    }
}
