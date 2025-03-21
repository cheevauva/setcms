<?php

declare(strict_types=1);

namespace SetCMS\Application\Router;

class RouterController extends Router
{

    #[\Override]
    protected function rules(): array
    {
        return $this->container->get('controllers');
    }
}
