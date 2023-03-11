<?php

declare(strict_types=1);

namespace SetCMS\Core;

class PrivateController extends DynamicController
{

    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\{module}PrivateController';
    }

}
