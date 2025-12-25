<?php

declare(strict_types=1);

namespace Module\SchedulerJob\Servant;

use Module\SchedulerJob\Entity\SchedulerJobEntity;
use Module\SchedulerJob\DAO\SchedulerJobHasByIdDAO;
use Module\SchedulerJob\DAO\SchedulerJobSaveDAO;
use Module\SchedulerJob\Exception\SchedulerJobNotFoundException;

class SchedulerJobUpdateServant extends \UUA\Servant
{

    public SchedulerJobEntity $schedulerJob;

    #[\Override]
    public function serve(): void
    {
        $hasById = SchedulerJobHasByIdDAO::new($this->container);
        $hasById->id = $this->schedulerJob->id;
        $hasById->serve();

        if (empty($hasById->isExists)) {
            throw new SchedulerJobNotFoundException;
        }

        $saveEntity = SchedulerJobSaveDAO::new($this->container);
        $saveEntity->schedulerJob = $this->schedulerJob;
        $saveEntity->serve();
    }
}
