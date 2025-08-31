<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\View;

use SetCMS\View\ViewTwig;

class CronSchedulerWorkPrivateNewView extends ViewTwig
{

    #[\Override]
    protected function templateName(): ?string
    {
        return parent::templateName() ?? 'CronSchedulerWorkPrivateEdit';
    }
}
