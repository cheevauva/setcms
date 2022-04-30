<?php

declare(strict_types=1);

namespace SetCMS\Controller;

class PublicController extends DynamicController
{

    use \SetCMS\Router\RouterTrait;

    protected function getSection(): string
    {
        return 'Public';
    }

}
