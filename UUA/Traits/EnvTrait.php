<?php

declare(strict_types=1);

namespace UUA\Traits;

trait EnvTrait
{

    use ContainerTrait;

    protected function env(): \UUA\ArrayObjectStrict
    {
        return new \UUA\ArrayObjectStrict($this->container->get('env'));
    }

}
