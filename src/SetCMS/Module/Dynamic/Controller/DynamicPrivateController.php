<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\Controller;

class DynamicPrivateController extends DynamicBaseController
{

    #[\Override]
    protected function classNameControllerPattern(): string
    {
        return 'SetCMS\Module\{module}\Controller\{module}Private{action}Controller';
    }

    #[\Override]
    protected function classNameResponderViewPatterns(): array
    {
        return [
            'SetCMS\Module\{module}\Responder\{module}Private{action}Responder',
            'SetCMS\Module\{module}\View\{module}Private{action}View',
        ];
    }
}
