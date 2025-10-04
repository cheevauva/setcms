<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\Controller;

use SetCMS\UUID;
use SetCMS\ControllerViaPSR7;
use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobRetrieveManyByCriteriaDAO;
use SetCMS\Module\SchedulerJob\View\SchedulerJobPrivateReadView;
use SetCMS\Application\Router\RouterMatchDTO;

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
        $validation = $this->validation(RouterMatchDTO::as($this->ctx['routerMatch'])->params);

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
