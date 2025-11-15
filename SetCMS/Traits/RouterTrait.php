<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SetCMS\Contract\ContractRouterInterface;
use SetCMS\Router\Router;

trait RouterTrait
{

    use \UUA\Traits\ContainerTrait;

    protected function router(): ContractRouterInterface
    {
        return Router::singleton($this->container);
    }
}
