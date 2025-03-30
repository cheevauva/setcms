<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

class DynamicPublicController extends DynamicBaseController
{

    #[\Override]
    protected function classNameControllerPattern(): string
    {
        return 'SetCMS\Module\{module}\Controller\{module}Public{action}Controller';
    }

}
