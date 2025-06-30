<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Controller;

use SetCMS\Module\CronSchedulerWork\View\CronSchedulerWorkPrivateEditView;

class CronSchedulerWorkPrivateEditController extends CronSchedulerWorkPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerWorkPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerWorkPrivateEditView) {
            $object->cronSchedulerWork = $this->cronSchedulerWork;
        }
    }
}
