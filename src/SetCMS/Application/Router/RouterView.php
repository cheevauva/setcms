<?php

declare(strict_types=1);

namespace SetCMS\Application\Router;

class RouterView extends Router
{

    #[\Override]
    protected function rules(): array
    {
        return $this->container->get('views');
    }
}
