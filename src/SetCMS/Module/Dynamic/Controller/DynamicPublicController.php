<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

class DynamicPublicController extends DynamicBaseController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\Controller\{module}PublicController';
    }

}
