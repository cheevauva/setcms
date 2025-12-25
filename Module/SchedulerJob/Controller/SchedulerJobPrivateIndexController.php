<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\SchedulerJob\DAO\SchedulerJobRetrieveManyByCriteriaDAO;
use Module\SchedulerJob\View\SchedulerJobPrivateIndexView;
use Module\SchedulerJob\Entity\SchedulerJobEntity;

class SchedulerJobPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var SchedulerJobEntity[]
     */
    protected array $schedulerJobs = [];

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
            SchedulerJobPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof SchedulerJobRetrieveManyByCriteriaDAO) {
            $this->schedulerJobs = $object->schedulerJobs;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof SchedulerJobPrivateIndexView) {
            $object->schedulerJobs = $this->schedulerJobs;
        }
    }
}
