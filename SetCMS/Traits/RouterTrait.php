<?php

declare(strict_types=1);

namespace SetCMS\Traits;

use SetCMS\Contract\ContractRouter;
use SetCMS\Router\Router;

trait RouterTrait
{

    use \UUA\Traits\ContainerTrait;

    protected function router(): ContractRouter
    {
        return Router::singleton($this->container);
    }
}
