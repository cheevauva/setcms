<?php

declare(strict_types=1);

namespace SetCMS\Module\SchedulerJob\Servant;

use SetCMS\UUID;
use SetCMS\Module\SchedulerJob\Entity\SchedulerJobEntity;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobRetrieveManyByCriteriaDAO;
use SetCMS\Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use SetCMS\Module\SchedulerJob\Exception\SchedulerJobNotFoundException;

class SchedulerJobDeleteServant extends \UUA\Servant
{

    public ?SchedulerJobEntity $schedulerJob = null;
    public ?UUID $id = null;

    #[\Override]
    public function serve(): void
    {
        $schedulerJobById = SchedulerJobRetrieveManyByCriteriaDAO::new($this->container);
        $schedulerJobById->id = $this->id ?? ($this->schedulerJob->id ?? throw new \RuntimeException('id is undefined'));
        $schedulerJobById->serve();

        if (!$schedulerJobById->schedulerJob) {
            throw new SchedulerJobNotFoundException;
        }

        $SchedulerJob = SchedulerJobEntity::as($schedulerJobById->schedulerJob);
        $SchedulerJob->deleted = true;

        $save = SchedulerJobSaveDAO::new($this->container);
        $save->schedulerJob = $SchedulerJob;
        $save->serve();

        $this->schedulerJob = $SchedulerJob;
    }
}
