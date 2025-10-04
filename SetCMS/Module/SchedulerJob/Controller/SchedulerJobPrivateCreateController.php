<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;
use SetCMS\Module\SchedulerJob\Servant\SchedulerJobCreateServant;
use SetCMS\Module\SchedulerJob\View\SchedulerJobPrivateCreateView;
use SetCMS\Module\SchedulerJob\Enum\SchedulerJobStatusEnum;

class SchedulerJobPrivateCreateController extends ControllerViaPSR7
{

    protected SchedulerJobEntity $schedulerJob;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerJobCreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerJobPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('SchedulerJob')->notEmpty()->validate();

        $this->schedulerJob = new SchedulerJobEntity();
        $this->schedulerJob->id = $validation->uuid('SchedulerJob.id')->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerJobCreateServant) {
            $object->schedulerJob = $this->schedulerJob;
        }

        if ($object instanceof SchedulerJobPrivateCreateView) {
            $object->schedulerJob = $this->schedulerJob;
        }
    }
}
