<?php

declare(strict_types=1);

namespace SetCMS\Controller;

class PrivateController extends DynamicController
{

    use \SetCMS\Router\RouterTrait;

    protected function getSection(): string
    {
        return 'Private';
    }

}
