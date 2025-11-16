<?php

declare(strict_types=1);

namespace Module\SchedulerJob\View;

use SetCMS\View\ViewTwig;

class SchedulerJobPrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'SchedulerJobPrivateEdit';
    }
}
