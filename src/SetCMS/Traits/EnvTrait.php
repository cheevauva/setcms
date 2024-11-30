<?php

declare(strict_types=1);

namespace SetCMS\Traits;

trait EnvTrait
{

    use DITrait;

    protected function env(): \ArrayObject
    {
        return new \ArrayObject($this->container->get('env'));
    }

}
