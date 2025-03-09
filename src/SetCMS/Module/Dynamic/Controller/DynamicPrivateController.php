<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

class DynamicPrivateController extends DynamicBaseController
{

    #[\Override]
    protected function classNamePattern(): string
    {
        return 'SetCMS\Module\{module}\Controller\{module}Private{action}Controller';
    }
}
