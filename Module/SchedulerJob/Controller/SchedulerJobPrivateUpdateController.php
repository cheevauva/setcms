<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\DAO\SchedulerJobRetrieveManyByCriteriaDAO;
use Module\SchedulerJob\Servant\SchedulerJobUpdateServant;
use Module\SchedulerJob\View\SchedulerJobPrivateUpdateView;

class SchedulerJobPrivateUpdateController extends ControllerViaPSR7
{

    protected SchedulerJobEntity $schedulerJob;
    protected SchedulerJobEntity $newSchedulerJob;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerJobRetrieveManyByCriteriaDAO::class,
            SchedulerJobUpdateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerJobPrivateUpdateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->request->getParsedBody());

        $this->newSchedulerJob = new SchedulerJobEntity;
        $this->newSchedulerJob->id = $validation->uuid('SchedulerJob.id')->notEmpty()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerJobRetrieveManyByCriteriaDAO) {
            $object->id = $this->newSchedulerJob->id;
            $object->orThrow = true;
        }

        if ($object instanceof SchedulerJobUpdateServant) {
            $object->schedulerJob = $this->schedulerJob;
        }

        if ($object instanceof SchedulerJobPrivateUpdateView) {
            $object->schedulerJob = $this->schedulerJob ?? null;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerJobRetrieveManyByCriteriaDAO) {
            $this->schedulerJob = SchedulerJobEntity::as($object->schedulerJob);
            $this->schedulerJob->status = $this->newSchedulerJob->status;
        }
    }
}
