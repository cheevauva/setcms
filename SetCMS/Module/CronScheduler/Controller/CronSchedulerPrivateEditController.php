<?php

declare(strict_types=1);

namespace SetCMS\Module\CronScheduler\Controller;

use SetCMS\Module\CronScheduler\View\CronSchedulerPrivateEditView;

class CronSchedulerPrivateEditController extends CronSchedulerPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerPrivateEditView) {
            $object->cronScheduler = $this->cronScheduler;
        }
    }
}
