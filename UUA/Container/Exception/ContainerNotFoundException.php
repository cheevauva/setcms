<?php

declare(strict_types=1);

namespace UUA\Container\Exception;

use Psr\Container\NotFoundExceptionInterface;

class ContainerNotFoundException extends \Exception implements NotFoundExceptionInterface
{
    //put your code here
}
