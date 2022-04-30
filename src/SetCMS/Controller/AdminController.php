<?php

declare(strict_types=1);

namespace SetCMS\Controller;

class AdminController extends DynamicController
{

    use \SetCMS\Router\RouterTrait;

    protected function getSection(): string
    {
        return 'Admin';
    }

}
