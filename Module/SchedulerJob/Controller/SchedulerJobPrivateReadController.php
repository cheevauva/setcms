<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Controller;

use SetCMS\UUID;
use SetCMS\Controller\ControllerViaPSR7;
use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\DAO\SchedulerJobRetrieveManyByCriteriaDAO;
use Module\SchedulerJob\View\SchedulerJobPrivateReadView;

class SchedulerJobPrivateReadController extends ControllerViaPSR7
{

    protected SchedulerJobEntity $schedulerJob;
    protected UUID $id;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SchedulerJobRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            SchedulerJobPrivateReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $validation = $this->validation($this->params);

        $this->id = $validation->uuid('id')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SchedulerJobRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->orThrow = true;
        }

        if ($object instanceof SchedulerJobPrivateReadView) {
            $object->schedulerJob = $this->schedulerJob;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerJobRetrieveManyByCriteriaDAO) {
            $this->schedulerJob = SchedulerJobEntity::as($object->schedulerJob);
        }
    }
}
