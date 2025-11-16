<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Controller;

use Module\SchedulerJob\View\SchedulerJobPrivateEditView;

class SchedulerJobPrivateEditController extends SchedulerJobPrivateReadController
{

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerJobPrivateEditView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerJobPrivateEditView) {
            $object->schedulerJob = $this->schedulerJob;
        }
    }
}
