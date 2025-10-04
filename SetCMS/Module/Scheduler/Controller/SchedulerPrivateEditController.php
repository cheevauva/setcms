<?php

declare(strict_types=1);

namespace SetCMS\Module\Scheduler\Controller;

use SetCMS\Module\Scheduler\View\SchedulerPrivateEditView;

class SchedulerPrivateEditController extends SchedulerPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerPrivateEditView) {
            $object->scheduler = $this->scheduler;
        }
    }
}
