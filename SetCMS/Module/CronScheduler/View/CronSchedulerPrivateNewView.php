<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\View;

use SetCMS\View\ViewTwig;

class CronSchedulerPrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'CronSchedulerPrivateEdit';
    }
}
