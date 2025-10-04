<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\View;

use SetCMS\View\ViewTwig;

class SchedulerPrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'SchedulerPrivateEdit';
    }
}
