<?php

declare(strict_types=1);

namespace SetCMS\Core;

class PublicController extends DynamicController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\{module}PublicController';
    }

}
