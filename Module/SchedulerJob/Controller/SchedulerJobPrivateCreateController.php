<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\Servant\SchedulerJobCreateServant;
use Module\SchedulerJob\View\SchedulerJobPrivateCreateView;
use Module\SchedulerJob\Enum\SchedulerJobStatusEnum;

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
